from fastapi import FastAPI, HTTPException
from pydantic import BaseModel, Field
import joblib
import numpy as np

APP_MODEL_PATH = "model/model_sipintar.joblib"

app = FastAPI(title="SIP AI - Analisis Stunting")

art = joblib.load(APP_MODEL_PATH)

class PayloadAnalisis(BaseModel):
    umur_bulan: int = Field(..., ge=0, le=24)
    berat_badan: float = Field(..., ge=0)
    tinggi_badan: float = Field(..., ge=0)
    jenis_kelamin: str = Field(..., pattern="^(L|P)$")
    tinggi_ibu: float = Field(..., ge=0)
    tinggi_ayah: float = Field(..., ge=0)

def buat_rasio_bb_tb(bb: float, tb: float) -> float:
    if tb <= 0:
        return 0.0
    return float(bb) / float(tb)

def ringkas(status: str, risiko: float) -> str:
    return f"Status {status} dengan estimasi risiko {risiko:.1f}%."

def rekomendasi_prioritas(defisit: dict, umur_bulan: int) -> list:
    # rekomendasi berbasis defisit prediksi (bukan rumus WHO)
    kandidat = []

    if defisit.get("defisit_protein") == 1:
        kandidat += ["telur", "ikan", "tempe", "ayam"]
    if defisit.get("defisit_energi") == 1:
        kandidat += ["nasi tim", "kentang", "ubi", "bubur kacang hijau"]
    if defisit.get("defisit_zat_besi") == 1:
        kandidat += ["hati ayam (porsi kecil)", "bayam", "daging sapi (cincang)"]
    if defisit.get("defisit_zink") == 1:
        kandidat += ["ikan", "telur", "kacang-kacangan"]
    if defisit.get("defisit_vitA") == 1:
        kandidat += ["wortel", "labu", "pepaya"]

    # rapikan + batasi
    seen = set()
    out = []
    for x in kandidat:
        if x not in seen:
            out.append(x)
            seen.add(x)
    if not out:
        out = ["pola makan seimbang sesuai umur"]

    return out[:8]

def faktor_sederhana(umur, bb, tb, ibu, ayah):
    # skor sederhana untuk dipakai sebagai "faktor_utama/pending" (masih data-driven di model utama)
    faktor = []
    if tb < (50 + umur*1.0):
        faktor.append(("tinggi badan relatif rendah untuk umur", 0.8))
    if bb < (3 + umur*0.2):
        faktor.append(("berat badan relatif rendah untuk umur", 0.7))
    if ibu < 150:
        faktor.append(("tinggi ibu cenderung rendah", 0.5))
    if ayah < 160:
        faktor.append(("tinggi ayah cenderung rendah", 0.4))

    if not faktor:
        faktor = [("parameter fisik relatif sesuai umur", 0.3)]

    utama = [{"nama": n, "skor": float(s)} for n, s in faktor[:3]]
    pendukung = [{"nama": n, "skor": float(s)} for n, s in faktor[3:6]]
    return utama, pendukung

@app.get("/health")
def health():
    return {"ok": True}

@app.post("/stunting/analisis")
def analisis(payload: PayloadAnalisis):
    rasio = buat_rasio_bb_tb(payload.berat_badan, payload.tinggi_badan)

    X = [{
        "umur_bulan": payload.umur_bulan,
        "berat_badan": payload.berat_badan,
        "tinggi_badan": payload.tinggi_badan,
        "jenis_kelamin": payload.jenis_kelamin,
        "tinggi_ibu": payload.tinggi_ibu,
        "tinggi_ayah": payload.tinggi_ayah,
        "rasio_bb_tb": rasio
    }]

    # status + confidence
    proba = art["model_status"].predict_proba(X)[0]
    idx = int(np.argmax(proba))
    status = art["model_status"].classes_[idx]
    confidence = float(proba[idx])

    # risiko %
    risiko = float(art["model_risiko"].predict(X)[0])
    risiko = max(0.0, min(100.0, risiko))

    # defisit
    pred_def = art["model_defisit"].predict(X)[0]
    defisit = {
        "defisit_protein": int(pred_def[0]),
        "defisit_energi": int(pred_def[1]),
        "defisit_zat_besi": int(pred_def[2]),
        "defisit_zink": int(pred_def[3]),
        "defisit_vitA": int(pred_def[4]),
    }

    # cluster
    num_cols = art["num_cols"]
    vec = np.array([[X[0][c] for c in num_cols]], dtype=float)
    vec_s = art["scaler_cluster"].transform(vec)
    id_klaster = int(art["kmeans"].predict(vec_s)[0])

    utama, pendukung = faktor_sederhana(payload.umur_bulan, payload.berat_badan, payload.tinggi_badan, payload.tinggi_ibu, payload.tinggi_ayah)

    return {
        "status_gizi": status,
        "tingkat_risiko": round(risiko, 2),
        "confidence": round(confidence, 4),
        "id_klaster": id_klaster,
        "ringkasan": ringkas(status, risiko),
        "faktor_utama": utama,
        "faktor_pendukung": pendukung,
        "rekomendasi_prioritas": rekomendasi_prioritas(defisit, payload.umur_bulan),
        "defisit": defisit,
        "z_score": None
    }