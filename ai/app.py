from fastapi import FastAPI, HTTPException
from pydantic import BaseModel, Field
import joblib
import numpy as np
import pandas as pd

# KONFIGURASI
MODEL_PATH = "model/model_sipintar.joblib"

app = FastAPI(
    title="SIPINTAR AI - Analisis Stunting",
    version="1.0.0"
)

# LOAD MODEL
try:
    ART = joblib.load(MODEL_PATH)
except Exception as e:
    raise RuntimeError(f"Gagal load model: {e}")

# SCHEMA INPUT
class PayloadAnalisis(BaseModel):
    umur_bulan: int = Field(..., ge=0, le=24)
    berat_badan: float = Field(..., gt=0)
    tinggi_badan: float = Field(..., gt=0)
    jenis_kelamin: str = Field(..., pattern="^(L|P)$")
    tinggi_ibu: float = Field(..., gt=0)
    tinggi_ayah: float = Field(..., gt=0)

# HELPER
def hitung_rasio(bb: float, tb: float) -> float:
    return bb / tb if tb > 0 else 0.0

# HEALTH CHECK
@app.get("/health")
def health():
    return {"status": "ok"}

# ENDPOINT ANALISIS STUNTING
@app.post("/stunting/analisis")
def analisis(payload: PayloadAnalisis):
    try:
        # BENTUK DATAFRAME
        X = pd.DataFrame([{
            "umur_bulan": payload.umur_bulan,
            "berat_badan": payload.berat_badan,
            "tinggi_badan": payload.tinggi_badan,
            "jenis_kelamin": payload.jenis_kelamin,
            "tinggi_ibu": payload.tinggi_ibu,
            "tinggi_ayah": payload.tinggi_ayah,
            "rasio_bb_tb": hitung_rasio(
                payload.berat_badan,
                payload.tinggi_badan
            )
        }])

        # STATUS GIZI (LOGISTIC / RF)
        proba = ART["model_status"].predict_proba(X)[0]
        idx = int(np.argmax(proba))
        status = ART["model_status"].classes_[idx]
        confidence = float(proba[idx])

        # RISIKO (%)
        risiko = float(ART["model_risiko"].predict(X)[0])
        risiko = max(0.0, min(100.0, risiko))

        # DEFISIT GIZI (MULTI-LABEL)
        d = ART["model_defisit"].predict(X)[0]
        defisit = {
            "defisit_protein": int(d[0]),
            "defisit_energi": int(d[1]),
            "defisit_zat_besi": int(d[2]),
            "defisit_zink": int(d[3]),
            "defisit_vitA": int(d[4]),
        }

        # CLUSTER (KMEANS)
        num_cols = ART["num_cols"]
        vec = X[num_cols].values
        vec = ART["scaler_cluster"].transform(vec)
        id_klaster = int(ART["kmeans"].predict(vec)[0])

        # RESPONSE FINAL
        return {
            "status_gizi": status,
            "tingkat_risiko": round(risiko, 2),
            "confidence": round(confidence, 4),
            "id_klaster": id_klaster,
            "ringkasan": f"Status {status} dengan estimasi risiko {risiko:.1f}%",
            "defisit": defisit,
            "rekomendasi_prioritas": [],
            "faktor_utama": [],
            "faktor_pendukung": [],
            "z_score": None
        }

    except Exception as e:
        raise HTTPException(
            status_code=500,
            detail=str(e)
        )