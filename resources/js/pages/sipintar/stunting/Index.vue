<script setup>
defineOptions({
  inheritAttrs: false
})
import { Head } from '@inertiajs/vue3'
import { ref, computed, onMounted, watch } from 'vue'
import axios from 'axios'

import {
  Chart,
  BarController, BarElement, CategoryScale, LinearScale,
  PieController, ArcElement,
  Tooltip, Legend,
} from 'chart.js'

Chart.register(
  BarController, BarElement, CategoryScale, LinearScale,
  PieController, ArcElement,
  Tooltip, Legend
)

const colors = {
  blue: '#2563eb',
  green: '#22c55e',
  orange: '#f97316',
  red: '#ef4444',
  teal: '#0ea5e9',
  purple: '#8b5cf6',
  pink: '#ec4899',
  blueSoft: '#93c5fd',
}

const props = defineProps({
  stunting: { type: Array, default: () => [] },
  summary: {
    type: Object,
    default: () => ({
      total: 0,
      normal: 0,
      stunting: 0,
      avg_risk: 0,
    }),
  },
  heatmap: { type: Array, default: () => [] },
  trend: { type: Array, default: () => [] },
  topKelurahan: { type: Array, default: () => [] },
  ageDist: { type: Array, default: () => [] },
  foodRecommendations: { type: Object, default: () => ({}) },
})

const predictions = ref([...props.stunting])

watch(
  () => props.stunting,
  (v) => { predictions.value = [...(v || [])] },
  { deep: true }
)

const monthLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']

const heatmapMatrix = computed(() => {
  const obj = {}
  let max = 0

  ;(props.heatmap || []).forEach(r => {
    const kec = r.kecamatan || 'Tidak diketahui'
    const bulan = Number(r.bulan)
    const val = Number(r.jumlah || 0)

    if (!obj[kec]) obj[kec] = {}
    obj[kec][bulan] = val
    if (val > max) max = val
  })

  return {
    rows: Object.entries(obj).map(([k, c]) => ({ kecamatan: k, counts: c })),
    max: max || 1
  }
})

const trendCanvas = ref(null)
let trendChart

const topKelCanvas = ref(null)
let topKelChart

const agePieCanvas = ref(null)
let agePieChart

const buildTrendChart = () => {
  if (!trendCanvas.value) return
  if (trendChart) trendChart.destroy()

  const ctx = trendCanvas.value.getContext('2d')

  const dataTrend = props.trend || []
  const periods = [...new Set(dataTrend.map(t => t.periode))].sort()
  const kecamatans = [...new Set(dataTrend.map(t => t.kecamatan || 'Tidak diketahui'))]

  const datasets = kecamatans.map((kec) => ({
    label: kec,
    backgroundColor: colors.orange,
    borderColor: colors.orange,
    borderRadius: 8,
    data: periods.map(p => {
      const rec = dataTrend.find(t => t.periode === p && (t.kecamatan || 'Tidak diketahui') === kec)
      return rec ? Number(rec.jumlah) : 0
    }),
  }))

  trendChart = new Chart(ctx, {
    type: 'bar',
    data: { labels: periods, datasets },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'bottom' } },
      scales: { y: { beginAtZero: true } }
    }
  })
}

const buildTopKelChart = () => {
  if (!topKelCanvas.value) return
  if (topKelChart) topKelChart.destroy()

  const ctx = topKelCanvas.value.getContext('2d')

  const top = props.topKelurahan || []
  topKelChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: top.map(i => i.kelurahan),
      datasets: [{
        label: 'Jumlah Anak',
        data: top.map(i => Number(i.jumlah || 0)),
        backgroundColor: [
          colors.orange, colors.green, colors.teal,
          colors.purple, colors.red,
        ],
        borderRadius: 10,
      }],
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      scales: { x: { beginAtZero: true } }
    }
  })
}

const buildPieChart = () => {
  if (!agePieCanvas.value) return
  if (agePieChart) agePieChart.destroy()

  const ctx = agePieCanvas.value.getContext('2d')

  const age = props.ageDist || []
  agePieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: age.map(a => a.label),
      datasets: [{
        data: age.map(a => Number(a.jumlah || 0)),
        backgroundColor: [
          colors.blue, colors.orange, colors.green, colors.purple,
          colors.teal, colors.red, colors.pink, colors.blueSoft
        ],
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'right' } }
    }
  })
}

onMounted(() => {
  buildTrendChart()
  buildTopKelChart()
  buildPieChart()
})

watch(
  () => [props.trend, props.topKelurahan, props.ageDist],
  () => {
    buildTrendChart()
    buildTopKelChart()
    buildPieChart()
  },
  { deep: true }
)

const selectedPrediksiId = ref(null)

const selectedAnak = computed(() =>
  (predictions.value || []).find(s => s.id_prediksi === selectedPrediksiId.value)
)

const selectedRekomendasiList = computed(() => {
  const key = String(selectedPrediksiId.value || '')
  return (props.foodRecommendations && props.foodRecommendations[key]) ? props.foodRecommendations[key] : []
})

async function runPrediction() {
  try {
    await axios.post('/ai/stunting/predict-all')
    window.location.reload()
  } catch (err) {
    console.error('ERROR:', err)
    alert('Prediksi gagal.')
  }
}

const safeSummary = computed(() => {
  const s = props.summary || {}
  return {
    total: Number(s.total || 0),
    normal: Number(s.normal || 0),
    stunting: Number(s.stunting || 0),
    avg_risk: Number(s.avg_risk || 0),
  }
})
</script>

<template>
  <Head title="Analisis Anak Berpotensi Stunting" />

  <div class="p-6 space-y-6">

    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-semibold text-slate-800">
        Data Anak Berpotensi Stunting
      </h1>

      <button
        @click="runPrediction"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition"
      >
        Jalankan Prediksi Ulang AI
      </button>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="p-4 rounded-xl border bg-white shadow">
        <p class="text-xs text-slate-500">Total Anak</p>
        <p class="text-2xl font-semibold">{{ safeSummary.total }}</p>
      </div>

      <div class="p-4 rounded-xl border bg-white shadow">
        <p class="text-xs text-emerald-600 font-medium">Anak Tidak Berisiko Stunting</p>
        <p class="text-2xl font-semibold text-emerald-600">{{ safeSummary.normal }}</p>
      </div>

      <div class="p-4 rounded-xl border bg-white shadow">
        <p class="text-xs text-rose-600 font-medium">Anak Berisiko / Stunting</p>
        <p class="text-2xl font-semibold text-rose-600">{{ safeSummary.stunting }}</p>
      </div>

      <div class="p-4 rounded-xl border bg-white shadow">
        <p class="text-xs text-slate-500">Rata-rata Risiko</p>
        <p class="text-2xl font-semibold">{{ safeSummary.avg_risk }}%</p>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="p-4 rounded-xl border bg-white shadow">
        <h2 class="text-sm font-semibold mb-2">Heatmap Risiko</h2>

        <table class="text-xs min-w-full">
          <thead>
            <tr>
              <th class="p-1 text-left">Kecamatan</th>
              <th v-for="m in monthLabels" :key="m" class="p-1 text-center">
                {{ m }}
              </th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="r in heatmapMatrix.rows" :key="r.kecamatan">
              <td class="p-1">{{ r.kecamatan }}</td>

              <td v-for="(m,i) in monthLabels" :key="i" class="p-1 text-center">
                <div
                  class="rounded-sm text-[10px]"
                  :style="{
                    backgroundColor:`rgba(37,99,235,${
                      (r.counts[i+1]||0)===0 ? 0.08 :
                      0.25 + 0.75*((r.counts[i+1]||0)/heatmapMatrix.max)
                    })`,
                    color:(r.counts[i+1]||0)>0?'white':'#64748b',
                    padding:'2px 0'
                  }"
                >
                  {{ r.counts[i+1] || '' }}
                </div>
              </td>
            </tr>

            <tr v-if="!heatmapMatrix.rows.length">
              <td class="p-2 text-slate-400" colspan="13">Belum ada data heatmap.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="p-4 rounded-xl border bg-white shadow">
        <h2 class="text-sm font-semibold mb-2">Trend Risiko 6 Bulan</h2>
        <div class="h-64">
          <canvas ref="trendCanvas"></canvas>
        </div>
        <p v-if="!(props.trend || []).length" class="text-xs text-slate-400 mt-2">
          Belum ada data trend.
        </p>
      </div>

      <div class="p-4 rounded-xl border bg-white shadow">
        <h2 class="text-sm font-semibold mb-2">Top 5 Kelurahan</h2>
        <div class="h-64">
          <canvas ref="topKelCanvas"></canvas>
        </div>
        <p v-if="!(props.topKelurahan || []).length" class="text-xs text-slate-400 mt-2">
          Belum ada data kelurahan.
        </p>
      </div>

      <div class="p-4 rounded-xl border bg-white shadow">
        <h2 class="text-sm font-semibold mb-2">Distribusi Umur Anak</h2>
        <div class="h-64">
          <canvas ref="agePieCanvas"></canvas>
        </div>
        <p v-if="!(props.ageDist || []).length" class="text-xs text-slate-400 mt-2">
          Belum ada data umur.
        </p>
      </div>
    </div>

    <div class="p-4 rounded-xl border bg-white shadow">
      <h2 class="text-sm font-semibold mb-3">Daftar Anak Stunting / Berisiko</h2>

      <table class="min-w-full text-[14px]">
        <thead>
          <tr class="bg-slate-50">
            <th class="px-3 py-2 text-left">Nama</th>
            <th class="px-3 py-2 text-left">Umur (bulan)</th>
            <th class="px-3 py-2 text-left">BB</th>
            <th class="px-3 py-2 text-left">TB</th>
            <th class="px-3 py-2 text-left">Status</th>
            <th class="px-3 py-2 text-left">Risiko</th>
            <th class="px-3 py-2 text-left">Kecamatan</th>
            <th class="px-3 py-2 text-left">Kelurahan</th>
            <th class="px-3 py-2 text-left">Posyandu</th>
            <th class="px-3 py-2 text-left">Aksi</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="row in predictions"
            :key="row.id_prediksi"
            class="border-t hover:bg-indigo-50 cursor-pointer"
            :class="{ 'bg-indigo-100': selectedPrediksiId === row.id_prediksi }"
            @click="selectedPrediksiId = row.id_prediksi"
          >
            <td class="px-3 py-2">{{ row.nama_bayi }}</td>
            <td class="px-3 py-2">{{ row.umur_bulan }}</td>
            <td class="px-3 py-2">{{ Number(row.berat_badan || 0).toFixed(1) }}</td>
            <td class="px-3 py-2">{{ Number(row.tinggi_badan || 0).toFixed(1) }}</td>
            <td class="px-3 py-2">{{ row.status_gizi }}</td>
            <td class="px-3 py-2">{{ Number(row.tingkat_risiko || 0).toFixed(2) }}%</td>
            <td class="px-3 py-2">{{ row.kecamatan }}</td>
            <td class="px-3 py-2">{{ row.kelurahan }}</td>
            <td class="px-3 py-2">{{ row.nama_posyandu }}</td>
            <td class="px-3 py-2">
              <button
                class="px-3 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"
                @click.stop="selectedPrediksiId = row.id_prediksi"
              >
                Lihat Rekomendasi
              </button>
            </td>
          </tr>

          <tr v-if="!predictions.length">
            <td colspan="10" class="text-center py-4 text-slate-400">
              Tidak ada data analisis. Jalankan dulu “Prediksi Ulang AI”.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="p-4 rounded-xl border bg-white shadow">
      <h2 class="text-sm font-semibold mb-3">Rekomendasi Makanan</h2>

      <div v-if="!selectedAnak" class="text-xs text-slate-500">
        Pilih salah satu anak dari tabel.
      </div>

      <div v-else>
        <div class="p-3 bg-slate-50 rounded-lg mb-3">
          <p class="text-sm text-slate-500">Anak:</p>
          <p class="font-semibold text-sm">{{ selectedAnak.nama_bayi }}</p>
          <p class="text-sm mt-1">
            {{ selectedAnak.umur_bulan }} bulan •
            {{ selectedAnak.kecamatan }} / {{ selectedAnak.kelurahan }}
          </p>
          <p class="text-sm mt-2">
            Ringkasan: {{ selectedAnak.rekomendasi }}
          </p>
        </div>

        <div class="space-y-3 max-h-64 overflow-y-auto text-sm">
          <div
            v-for="(rec,i) in selectedRekomendasiList"
            :key="i"
            class="p-3 border rounded-lg"
          >
            <p class="text-slate-500 text-xs">{{ rec.jenis_makanan }}</p>
            <p class="font-semibold">{{ rec.nama_makanan }}</p>
            <p class="mt-1">Porsi: {{ rec.porsi_harian }}</p>
            <p class="mt-1">Gizi: {{ rec.kandungan_gizi }}</p>
            <p v-if="rec.catatan" class="italic text-slate-500 mt-1">
              Catatan: {{ rec.catatan }}
            </p>
          </div>

          <p v-if="!selectedRekomendasiList.length" class="text-center text-slate-400">
            Tidak ada rekomendasi makanan untuk analisis ini.
          </p>
        </div>
      </div>
    </div>

  </div>
</template>
<style scoped>
* {
  font-size: 15px;
  line-height: 1.6;
  color: #1e293b; 
}

h1 {
  font-size: 24px;
  font-weight: 700;
  color: #0f172a; 
}

h2 {
  font-size: 18px;
  font-weight: 600;
  color: #0f172a;
}

.grid > div p:first-child {
  font-size: 13px;
  font-weight: 500;
  color: #475569; /* slate-600 */
}

.grid > div p:last-child {
  font-size: 26px;
  font-weight: 700;
  color: #0f172a;
}

table {
  font-size: 14px;
}

thead th {
  font-size: 14px;
  font-weight: 600;
  color: #0f172a;
}

tbody td {
  font-size: 14px;
  color: #1e293b;
}

table .text-\[10px\] {
  font-size: 12px !important;
  font-weight: 600;
}

button {
  font-size: 14px;
  font-weight: 600;
}

.space-y-3 > div {
  font-size: 15px;
}

.space-y-3 p {
  font-size: 14px;
}

.space-y-3 .font-semibold {
  font-size: 16px;
  color: #0f172a;
}

.italic {
  font-size: 13px;
  color: #475569; /* slate-600 */
}

.text-slate-400,
.text-slate-500 {
  font-size: 14px;
  color: #64748b !important;
}
</style>