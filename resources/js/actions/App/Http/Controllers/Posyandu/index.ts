import WuspusBiodataController from './WuspusBiodataController'
import WuspusImunisasiController from './WuspusImunisasiController'
import WuspusKontrasepsiController from './WuspusKontrasepsiController'
import WuspusKematianController from './WuspusKematianController'
import BumilBiodataController from './BumilBiodataController'
import BumilImunisasiController from './BumilImunisasiController'
import BumilPenimbanganController from './BumilPenimbanganController'

const Posyandu = {
    WuspusBiodataController: Object.assign(WuspusBiodataController, WuspusBiodataController),
    WuspusImunisasiController: Object.assign(WuspusImunisasiController, WuspusImunisasiController),
    WuspusKontrasepsiController: Object.assign(WuspusKontrasepsiController, WuspusKontrasepsiController),
    WuspusKematianController: Object.assign(WuspusKematianController, WuspusKematianController),
    BumilBiodataController: Object.assign(BumilBiodataController, BumilBiodataController),
    BumilImunisasiController: Object.assign(BumilImunisasiController, BumilImunisasiController),
    BumilPenimbanganController: Object.assign(BumilPenimbanganController, BumilPenimbanganController),
}

export default Posyandu