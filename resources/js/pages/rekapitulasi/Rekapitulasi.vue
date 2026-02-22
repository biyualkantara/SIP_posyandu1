<script setup>
import Card from '@/components/ui/Card.vue';
import CardIcon from '@/components/ui/CardIcon.vue';
import { ref } from 'vue';
import BaseModal from '@/components/ui/Modal.vue';
import ModalHeader from '@/components/ui/ModalHeader.vue';
import ModalBody from '@/components/ui/ModalBody.vue';
import ModalFooter from '@/components/ui/ModalFooter.vue';
import VueSelect from 'vue3-select-component';
import { Form, useForm } from '@inertiajs/vue3';

const props = defineProps({
    kecamatan: Array,
    kelurahan: Object,
    posyandu: Object,
});

const modalOpen = ref(false);
const format = ref(null);

function openModal(selectedFormat) {
    format.value = selectedFormat;
    modalOpen.value = true;
}

const form = useForm({
    id_kecamatan: '',
    id_kelurahan: '',
    id_posyandu: '',
    tahun: 'All',
});

function exportData() {
    const queryParams = new URLSearchParams({
        id_kecamatan: form.id_kecamatan,
        id_kelurahan: form.id_kelurahan,
        id_posyandu: form.id_posyandu,
        tahun: form.tahun,
    }).toString();

    const url = `/rekapitulasi/${format.value}/export?${queryParams}`;
    window.location.href = url;
    modalOpen.value = false;

    // clear form
    form.id_kecamatan = '';
    form.id_kelurahan = ''; 
    form.id_posyandu = '';
    form.tahun = 'All';
}
function displayFormat(formatKey) {
    switch (formatKey) {
        case 'f1':
            return 'FORMAT 1';
        case 'f2':
            return 'FORMAT 2';
        case 'f3':
            return 'FORMAT 3';
        case 'f4':
            return 'FORMAT 4';
        case 'f5':
            return 'FORMAT 5';
        case 'f6':
            return 'FORMAT 6';
        default:
            return '';
    }
}

import babyboy from '../../../images/baby-boy.png'
import hospital from '../../../images/hospital.png'
import maternityCare from '../../../images/maternity-care.png'
import medicalReport from '../../../images/medical-report.png'
import parents from '../../../images/parents.png'

</script>

<template>
    <AdminLayout>
        <div class="mt-3 p-4 bg-white">
            <h1>Rekapitulasi SIP</h1>
            <hr>
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <Card>
                        <template #icon>
                            <CardIcon :src="babyboy" />
                        </template>

                        <template #title>FORMAT 1</template>

                        <template #description>
                            Catatan Ibu Hamil, Kelahiran, Kematian Bayi, <br />
                            dan Kematian Ibu Hamil, Melahirkan / Nifas.
                        </template>

                        <template #actions>
                            <button class="btn btn-primary btn-block" @click="openModal('f1')">DOWNLOAD</button>
                        </template>
                    </Card>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <Card>
                        <template #icon>
                            <CardIcon :src="medicalReport" />
                        </template>

                        <template #title>FORMAT 2</template>

                        <template #description>
                            Register Bayi Dan Balita Dalam Wilayah Kerja Posyandu
                        </template>

                        <template #actions>
                            <button class="btn btn-primary btn-block" @click="openModal('f2')"> DOWNLOAD</button>
                        </template>
                    </Card>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <Card>
                        <template #icon>
                            <CardIcon :src="parents" />
                        </template>

                        <template #title>FORMAT 3</template>

                        <template #description>
                            Register Wus Dan Pus Dalam Wilayah Kerja Posyandu
                        </template>

                        <template #actions>
                            <button class="btn btn-primary btn-block" @click="openModal('f3')">DOWNLOAD</button>
                        </template>
                    </Card>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <Card>
                        <template #icon>
                            <CardIcon :src="maternityCare" />
                        </template>

                        <template #title>FORMAT 4</template>

                        <template #description>
                            Register Ibu Hamil Di Wilayah Kerja Posyandu
                        </template>

                        <template #actions>
                            <button class="btn btn-primary btn-block" @click="openModal('f4')">DOWNLOAD</button>
                        </template>
                    </Card>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <Card>
                        <template #icon>
                            <CardIcon :src="hospital" />
                        </template>

                        <template #title>FORMAT 5</template>

                        <template #description>
                            Jumlah Pengunjung / Jumlah Petugas Posyandu / Jumlah Bayi Lahir / Meninggal
                        </template>

                        <template #actions>
                            <button class="btn btn-primary btn-block" @click="openModal('f5')">DOWNLOAD</button>
                        </template>
                    </Card>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <Card>
                         <template #icon>
                            <CardIcon :src="maternityCare" />
                        </template>

                        <template #title>FORMAT 6</template>

                        <template #description>
                            Data Hasil Kegiatan Posyandu
                        </template>

                        <template #actions>
                            <button class="btn btn-primary btn-block" @click="openModal('f6')">DOWNLOAD</button>
                        </template>
                    </Card>
                </div>
            </div>
        </div>

        <div class="overlay" style="inset: 0; background-color: gray; opacity: 0.5; position: fixed;" v-if="modalOpen" @click="modalOpen = false">
        </div>

        <BaseModal :show="modalOpen" @close="modalOpen = false">
            <template #header>
            <ModalHeader @close="modalOpen = false">
                <h2>Ekspor {{ displayFormat(format) }}</h2>
            </ModalHeader>
            </template>

            <template #body>
            <ModalBody>
                <!-- pilih kecamatan, kelurahan, posyandu -->
                <p>Apakah Anda yakin ingin mengekspor data dengan format {{ format }}?</p>
                
                <div class="form-group">
                    <label for="kecamatan">Pilih Kecamatan</label>
                    <VueSelect
                        class="mt-2"
                        label="Pilih Kecamatan"
                        v-model="form.id_kecamatan"
                        :options="kecamatan.map(kec => ({ label: kec.nama_kec, value: kec.id_kec }))"
                        name="id_kecamatan"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="kelurahan">Pilih Kelurahan</label>
                    <VueSelect
                        class="mt-4"
                        label="Pilih Kelurahan"
                    v-model="form.id_kelurahan"
                    :options="kelurahan[form.id_kecamatan]?.map(kel => ({ label: kel.nama_kel, value: kel.id_kel })) || []"
                    name="id_kelurahan"
                    required
                />
                </div>

                <div class="form-group">
                    <label for="posyandu">Pilih Posyandu</label>
                    <VueSelect
                        class="mt-4"
                        label="Pilih Posyandu"
                        v-model="form.id_posyandu"
                    :options="posyandu[form.id_kelurahan]?.map(pos => ({ label: pos.nama_posyandu, value: pos.id_posyandu })) || []"
                    name="id_posyandu"
                    required
                />
                </div>

                <div class="form-group">
                    <label for="tahun">Pilih Tahun</label>
                    <VueSelect
                        class="mt-4"
                        label="Pilih Tahun"
                        v-model="form.tahun"
                        :options="[2020, 2021, 2022, 2023, 2024, 2025].map(tahun => ({ label: tahun.toString(), value: tahun }))"
                        name="tahun"
                />
                </div>


            </ModalBody>
            </template>

            <template #footer>
                <ModalFooter>
                <button type="buttom" class="btn btn-link" @click.prevent="modalOpen = false">Tidak</button>
                <button type="submit" class="btn btn-primary" @click.prevent="exportData">Ya, Ekspor</button>
            </ModalFooter>
            </template>
        </BaseModal>
    </AdminLayout>
</template>