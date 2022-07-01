<template>
    <modal :modal-id="modalId"
           modal-size="large"
           :title="selectedUrl ? $t('edit_client') : $t('add_client')"
           :preloader="preloader"
           @submit="submit"
           @closeModal="closeModal">
        <template slot="body">
            <app-overlay-loader v-if="preloader"/>
            <form class="mb-0"
                  :class="{'loading-opacity': preloader}"
                  ref="form"
                  :data-url="selectedUrl ? selectedUrl : 'clients'">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="clientNumber">
                                {{ $t('client_number') }}<sup class="text-size-20 top-1">*</sup>
                            </label>
                            <app-input
                                id="clientNumber"
                                type="number"
                                :placeholder="$t('enter_client_number')"
                                v-model="formData.client_number"
                                :error-message="$errorMessage(errors, 'client_number')"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">
                                {{ $t('name') }}<sup class="text-size-20 top-1">*</sup>
                            </label>
                            <app-input
                                id="name"
                                type="text"
                                :placeholder="$t('enter_client_name')"
                                v-model="formData.full_name"
                                :error-message="$errorMessage(errors, 'full_name')"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">
                                {{ $t('email') }}<sup class="text-size-20 top-1">*</sup>
                            </label>
                            <app-input
                                id="email"
                                type="email"
                                :placeholder="$t('enter_client_email')"
                                v-model="formData.email"
                                :error-message="$errorMessage(errors, 'email')"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contactNumber">
                                {{ $t('contact_number') }}
                            </label>
                            <app-input
                                id="contactNumber"
                                type="tel-input"
                                :placeholder="$t('enter_contact_number')"
                                v-model="formData.phone"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contactNumber">
                              TRN
                            </label>
                            <app-input
                                id="trn"
                                type="text"
                                :placeholder="TRN"
                                v-model="formData.trn"
                            />
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="address">{{ $t('address') }}</label>
                            <app-input
                                :id="`address`"
                                type="textarea"
                                :text-area-rows="4"
                                :placeholder="$t('enter_address')"
                                v-model="formData.address"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">
                                {{ $t('city') }}
                            </label>
                            <app-input
                                id="city"
                                type="text"
                                :placeholder="$t('enter_city_name')"
                                v-model="formData.city"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="state">
                                {{ $t('state') }}
                            </label>
                            <app-input
                                id="state"
                                type="text"
                                :placeholder="$t('enter_state_name')"
                                v-model="formData.state"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postalCode">
                                {{ $t('postal_code') }}
                            </label>
                            <app-input
                                id="postalCode"
                                type="text"
                                :placeholder="$t('enter_postal_code')"
                                v-model="formData.postal_code"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">
                                {{ $t('country') }}
                            </label>
                            <app-input
                                id="country"
                                type="search-select"
                                :placeholder="$t('choose_country')"
                                :list="countryList"
                                list-value-field="value"
                                v-model="formData.country_id"
                            />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="website">
                                {{ $t('website') }}
                            </label>
                            <app-input
                                id="website"
                                type="text"
                                :placeholder="$t('enter_website_url')"
                                v-model="formData.website_url"
                            />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="notes">
                                {{ $t('notes') }}
                            </label>
                            <app-input
                                id="notes"
                                type="textarea"
                                :text-area-rows="4"
                                :placeholder="$t('enter_a_note')"
                                v-model="formData.notes"
                            />
                        </div>
                    </div>
                </div>
            </form>
        </template>
    </modal>
</template>

<script>

import {SubmitFormMixins} from "../../../Mixins/billar/SubmitFormMixins";

export default {
    name: 'ClientAddEditModal',
    mixins: [SubmitFormMixins],
    props: {
        tableId: {
            type: String
        },
        countryList: {
            type: Array
        }
    },
    data() {
        return {
            modalId: 'client-add-edit-modal',
            formData: {
                full_name: '',
                trn: ''
            },
        }
    },
    methods: {
        submit() {
            const {first_name, last_name} = this.names;
            const formData = {...this.formData, first_name, last_name }
            this.save(formData);
        },

        afterSuccessFromGetEditData(response) {
            this.formData = response.data;
            this.formData.phone = this.formData.user?.profile?.contact ? this.formData.user.profile.contact : '';
            this.formData.address = this.formData.user?.profile?.address ? this.formData.user.profile.address : '';
            this.formData.email = this.formData.user?.email;
            this.formData.full_name = this.formData.user?.full_name;
            this.formData.trn = this.formData.user?.trn;
        }
    },
    computed: {
        names() {
            const full_name_spited = this.formData.full_name.split(' ').filter(name => name);
            if (full_name_spited.length) {
                if (full_name_spited.length === 2) {
                    return {
                        first_name: full_name_spited[0],
                        last_name: full_name_spited[1]
                    }
                } else if (full_name_spited.length === 1) {
                    return {
                        first_name: full_name_spited[0],
                        last_name: ''
                    }
                } else if (full_name_spited.length === 3) {
                    return {
                        first_name: `${full_name_spited[0]} ${full_name_spited[1]}`,
                        last_name: full_name_spited[2]
                    }
                } else {
                    return {
                        first_name: full_name_spited[0],
                        last_name: full_name_spited.slice(1, full_name_spited.length).join(' ')
                    }
                }
            }
            return {
                first_name: '',
                last_name: ''
            }
        }
    }
}
</script>