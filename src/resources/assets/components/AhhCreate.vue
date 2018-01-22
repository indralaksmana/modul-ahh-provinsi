<template>
    <div class="row">
        <div class="col-lg-12">
            <b-card class="mb-2 bg-default-card" header="Tambah Harapan Lama Sekolah (RLS) Provinsi Banten" header-tag="h4">
                <div>
                    <vue-form :state="formstate" @submit.prevent="onSubmit">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <validate tag="div">
                                        <label for="ahhprovinsiProvinceKode"> Provinsi</label>
                                        <select name="ahhprovinsiProvinceKode" class="form-control" id="ahhprovinsiProvinceKode" v-model="ahhprovinsiProvinceKode" @change="getKota()" required checkbox>
                                            <option value="0" selected disabled>Pilih Provinsi</option>
                                            <option :value="province.provinsi_kode" v-for="province in provinces">
                                                {{ province.provinsi_nama }}
                                            </option>
                                        </select>
                                        <field-messages name="ahhprovinsiProvinceKode" show="$invalid && $submitted" class="text-danger">
                                            <div slot="checkbox">Provinsi dibutuhkan.</div>
                                        </field-messages>
                                    </validate>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <validate tag="div">
                                        <label for="ahhprovinsiKotaKode"> Kota</label>
                                        <select name="ahhprovinsiKotaKode" class="form-control" id="ahhprovinsiKotaKode" v-model="ahhprovinsiKotaKode" required checkbox>
                                            <option value="0" selected disabled>Pilih Kota</option>
                                            <option :value="city.kota_kode" v-for="city in cities">
                                                {{ city.kota_nama }}
                                            </option>
                                        </select>
                                        <field-messages name="ahhprovinsiKotaKode" show="$invalid && $submitted" class="text-danger">
                                            <div slot="checkbox">Kota dibutuhkan.</div>
                                        </field-messages>
                                    </validate>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <validate tag="div">
                                        <label for="ahhprovinsiTgl"> Tanggal</label>
                                        <input type="date" name="ahhprovinsiTgl" class="form-control input-sm" id="ahhprovinsiTgl" value="yyyy-mm-dd" aria-selected="true" v-model="ahhprovinsiTgl" required>
                                        <field-messages name="ahhprovinsiTgl" show="$invalid && $submitted" class="text-danger">
                                            <div slot="required">Tanggal dibutuhkan.</div>
                                        </field-messages>
                                    </validate>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <validate tag="div">
                                        <label for="ahhprovinsiValue"> Jumlah</label>
                                        <input type="number" name="ahhprovinsiValue" class="form-control input-sm" id="ahhprovinsiValue" placeholder="Masukkan Jumlah" v-model="ahhprovinsiValue" required>
                                        <field-messages name="ahhprovinsiValue" show="$invalid && $submitted" class="text-danger">
                                            <div slot="required">Jumlah dibutuhkan.</div>
                                        </field-messages>
                                    </validate>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <b-button type="submit" size="md" variant="primary">
                                        <i class="ti-save"></i> Simpan
                                    </b-button>
                                    <router-link to="/" class="btn btn-danger"><i class="ti-arrow-left"></i> KEMBALI</router-link>
                                </div>
                            </div>
                        </div>
                    </vue-form>
                </div>
            </b-card>
        </div>
    </div>
</template>
<script>
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
export default {
    name: "ahhcreate",
    data() {
        return {
            provinces: [],
            cities: [],
            ahhprovinsiProvinceKode: 0,
            ahhprovinsiKotaKode: 0,
            ahhprovinsiTgl: "",
            ahhprovinsiValue: 0,
            formstate: {}
        }
    },
    methods: {
        onSubmit: function() {
            if (this.formstate.$invalid) {
                return;
            } else {
                axios.post('/create', {
                    ahhprovinsiProvinceKode: this.ahhprovinsiProvinceKode,
                    ahhprovinsiKotaKode: this.ahhprovinsiKotaKode,
                    ahhprovinsiTgl: this.ahhprovinsiTgl,
                    ahhprovinsiValue: this.ahhprovinsiValue
                })
                .then(response => {
                    this.$router.push({ name: 'list'})
                })
                .catch(function(error) {});
            }

        },
        getKota: function () {
            var val = this.ahhprovinsiProvinceKode;
            axios.get("/getKota/"+val)
                .then(response => {
                    this.cities = response.data;
                })
                .catch(function(error) {});
        }
    },
    mounted: function() {
        axios.get("/getProvinsi")
            .then(response => {
                this.provinces = response.data;
            })
            .catch(function(error) {});
    },
    destroyed: function() {

    }
}
</script>