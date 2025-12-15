<script setup>
import Card from '@/components/ui/Card.vue';
import CardIcon from '@/components/ui/CardIcon.vue';
import { ref } from 'vue';
import BaseModal from '@/components/ui/Modal.vue';
import ModalHeader from '@/components/ui/ModalHeader.vue';
import ModalBody from '@/components/ui/ModalBody.vue';
import ModalFooter from '@/components/ui/ModalFooter.vue';
import VueSelect from 'vue3-select-component';
import { useForm } from '@inertiajs/vue3';

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
    tahun: '',
});
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
                            <CardIcon src="https://www.svgrepo.com/show/306220/icomoon.svg" />
                        </template>

                        <template #title>FORMAT 1</template>

                        <template #description>
                            Catatan Ibu Hamil, Kelahiran, Kematian Bayi, <br />
                            dan Kematian Ibu Hamil, Melahirkan / Nifas.
                        </template>

                        <template #actions>
                            <button class="btn btn-primary btn-block" @click="openModal('FORMAT 1')">DOWNLOAD</button>
                        </template>
                    </Card>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <Card>
                        <template #icon>
                            <CardIcon src="https://www.svgrepo.com/show/306220/icomoon.svg" />
                        </template>

                        <template #title>FORMAT 1</template>

                        <template #description>
                            Catatan Ibu Hamil, Kelahiran, Kematian Bayi, <br />
                            dan Kematian Ibu Hamil, Melahirkan / Nifas.
                        </template>

                        <template #actions>
                            <button class="btn btn-primary btn-block" @click="openModal('FORMAT 2')"> DOWNLOAD</button>
                        </template>
                    </Card>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <Card>
                        <template #icon>
                            <CardIcon src="https://www.svgrepo.com/show/306220/icomoon.svg" />
                        </template>

                        <template #title>FORMAT 1</template>

                        <template #description>
                            Catatan Ibu Hamil, Kelahiran, Kematian Bayi, <br />
                            dan Kematian Ibu Hamil, Melahirkan / Nifas.
                        </template>

                        <template #actions>
                            <button class="btn btn-primary btn-block" @click="openModal('FORMAT 3')">DOWNLOAD</button>
                        </template>
                    </Card>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <Card>
                        <template #icon>
                            <CardIcon src="https://www.svgrepo.com/show/306220/icomoon.svg" />
                        </template>

                        <template #title>FORMAT 1</template>

                        <template #description>
                            Catatan Ibu Hamil, Kelahiran, Kematian Bayi, <br />
                            dan Kematian Ibu Hamil, Melahirkan / Nifas.
                        </template>

                        <template #actions>
                            <button class="btn btn-primary btn-block" @click="openModal('FORMAT 4')">DOWNLOAD</button>
                        </template>
                    </Card>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <Card>
                        <template #icon>
                            <CardIcon src="https://www.svgrepo.com/show/306220/icomoon.svg" />
                        </template>

                        <template #title>FORMAT 1</template>

                        <template #description>
                            Catatan Ibu Hamil, Kelahiran, Kematian Bayi, <br />
                            dan Kematian Ibu Hamil, Melahirkan / Nifas.
                        </template>

                        <template #actions>
                            <button class="btn btn-primary btn-block" @click="openModal('FORMAT 5')">DOWNLOAD</button>
                        </template>
                    </Card>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <Card>
                        <template #icon>
                            <CardIcon src="https://www.svgrepo.com/show/306220/icomoon.svg" />
                        </template>

                        <template #title>FORMAT 1</template>

                        <template #description>
                            Catatan Ibu Hamil, Kelahiran, Kematian Bayi, <br />
                            dan Kematian Ibu Hamil, Melahirkan / Nifas.
                        </template>

                        <template #actions>
                            <button class="btn btn-primary btn-block" @click="openModal('FORMAT 6')">DOWNLOAD</button>
                        </template>
                    </Card>
                </div>
            </div>
        </div>

        <Form :action="`/data_bayi/rekapitulasi/format/${format}/export`" method="POST">
            <BaseModal :show="modalOpen" @close="modalOpen = false">
                <template #header>
                <ModalHeader @close="modalOpen = false">
                    <h2>Ekspor {{ format }}</h2>
                </ModalHeader>
                </template>

                <template #body>
                <ModalBody>
                    <!-- pilih kecamatan, kelurahan, posyandu -->
                    <p>Apakah Anda yakin ingin mengekspor data dengan format {{ format }}?</p>
                    
                    <VueSelect
                        class="mt-2"
                        label="Pilih Kecamatan"
                        v-model="form.id_kecamatan"
                        :options="kecamatan.map(kec => ({ label: kec.nama_kec, value: kec.id_kec }))"
                        name="id_kecamatan"
                        required
                    />

                    <VueSelect
                        class="mt-4"
                        label="Pilih Kelurahan"
                        v-model="form.id_kelurahan"
                        :options="kelurahan[form.id_kecamatan]?.map(kel => ({ label: kel.nama_kel, value: kel.id_kel })) || []"
                        name="id_kelurahan"
                        required
                    />

                    <VueSelect
                        class="mt-4"
                        label="Pilih Posyandu"
                        v-model="form.id_posyandu"
                        :options="posyandu[form.id_kelurahan]?.map(pos => ({ label: pos.nama_posyandu, value: pos.id_posyandu })) || []"
                        name="id_posyandu"
                        required
                    />

                    <!-- select tahun (optional) -->
                   <VueSelect
                        class="mt-4"
                        label="Pilih Tahun (Optional)"
                        v-model="form.tahun"
                        :options="[2020, 2021, 2022, 2023, 2024, 2025].map(tahun => ({ label: tahun.toString(), value: tahun }))"
                        name="tahun"
                    />


                </ModalBody>
                </template>

                <template #footer>
                    <ModalFooter>
                    <button type="buttom" class="btn btn-link" @click.prevent="modalOpen = false">Tidak</button>
                    <button type="submit" class="btn btn-primary">Ya, Ekspor</button>
                </ModalFooter>
                </template>
            </BaseModal>
        </Form>
    </AdminLayout>
</template>