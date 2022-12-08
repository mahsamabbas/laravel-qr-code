<template>
    <div>
        <navbar-component />

        <b-row>
            <b-col md="6">
                <b-card id="cardLogin" class="scale-in-bl">
                    <b-form @submit.prevent="onSubmit" id="formLogin">
                        <h1 class="text-center mb-3">Qr Form</h1>

                        <b-row class="lineHeight">
                            <div
                                :class="{ 'form-group--error': $v.size.$error }"
                            >
                                <b-form-group
                                    id="input-group-1"
                                    label-for="content"
                                >
                                    <b-form-input
                                        id="size"
                                        class="input"
                                        v-model="size"
                                        type="text"
                                        placeholder="Please add size"
                                    ></b-form-input>
                                </b-form-group>
                            </div>
                            <div v-if="$v.size.$error">
                                <span class="error" v-if="!$v.size.required">
                                    Required
                                </span>
                                <span class="error" v-if="!$v.size.minLength">
                                    Minimum length must be 1
                                </span>
                                <span class="error" v-if="!$v.size.maxLength">
                                    Max length must be less than 4 digits
                                </span>
                                <span class="error" v-if="!$v.size.integer">
                                    integers only
                                </span>
                            </div>
                        </b-row>

                        <b-row class="lineHeight">
                            <div
                                :class="{
                                    'form-group--error': $v.content.$error,
                                }"
                            >
                                <b-form-group
                                    id="input-group-1"
                                    label-for="content"
                                >
                                    <b-form-input
                                        id="content"
                                        class="input"
                                        v-model="content"
                                        type="text"
                                        placeholder="Please add content"
                                    ></b-form-input>
                                </b-form-group>
                            </div>
                            <div v-if="$v.content.$error">
                                <span class="error" v-if="!$v.content.required">
                                    Required
                                </span>
                                <span
                                    class="error"
                                    v-if="!$v.content.minLength"
                                >
                                    Minimum length must be 3
                                </span>
                                <span
                                    class="error"
                                    v-if="!$v.content.maxLength"
                                >
                                    Max length must be less than 10
                                </span>
                            </div>
                        </b-row>

                        <b-row class="lineHeight">
                            <b-col md="6">
                                <b-form-group
                                    id="input-group-1"
                                    label-for="color"
                                >
                                    Background color
                                    <color-picker
                                        :color="color"
                                        :sucker-hide="false"
                                        :sucker-canvas="suckerCanvas"
                                        :sucker-area="suckerArea"
                                        @changeColor="changeColor"
                                    />
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    style="float: right !important"
                                    id="input-group-1"
                                    label-for="colorFill"
                                >
                                    Fill color
                                    <color-picker
                                        :color="colorFill"
                                        :sucker-hide="false"
                                        :sucker-canvas="suckerCanvasFill"
                                        :sucker-area="suckerAreaFill"
                                        @changeColor="changeColorFill"
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <div class="d-flex justify-content-center mt-6">
                            <b-button
                                class="buttonSizeAll"
                                type="submit"
                                variant="outline-primary"
                                >Get Qr</b-button
                            >
                        </div>
                    </b-form>
                </b-card>
            </b-col>
            <b-col md="6">
                <h1 class="text-center mb-3 titleQr">Preview</h1>
                <b-row>
                    <img :src="response" class="finalImage" />
                </b-row>
            </b-col>
        </b-row>
    </div>
</template>

<script>
import colorPicker from "@caohenghu/vue-colorpicker";
import NavbarComponent from "./NavbarComponent.vue";

import {
    required,
    minLength,
    maxLength,
    numeric,
} from "vuelidate/lib/validators";

export default {
    name: "User",
    components: {
        colorPicker,
        NavbarComponent,
    },
    data() {
        return {
            color: "255,255,255,1",
            suckerCanvas: null,
            suckerArea: [],
            isSucking: false,
            colorFill: "255,255,255,1",
            suckerCanvasFill: null,
            suckerAreaFill: [],
            isSuckingFill: false,
            content: "",
            size: null,
            response: null,
        };
    },
    methods: {
        changeColor(color) {
            let backgroundColor =
                color.rgba.r +
                "," +
                color.rgba.g +
                "," +
                color.rgba.b +
                "," +
                color.rgba.a;
            this.color = backgroundColor;
        },
        changeColorFill(color) {
            this.colorFill =
                color.rgba.r +
                "," +
                color.rgba.g +
                "," +
                color.rgba.b +
                "," +
                color.rgba.a;
        },

        onSubmit() {
            this.$v.$touch();
            if (this.$v.$invalid) {
                return false;
            }

            this.color;
            this.colorFill;
            this.content;
            this.size;
            let urlEndPoint =
                "backgroundcolor=" +
                this.color +
                "&fillcolor=" +
                this.colorFill +
                "&size=" +
                this.size +
                "&content=" +
                this.content;

            let authToken = localStorage.getItem("qrCodeToken");

            if (authToken == null) {
                return;
            }
            const AuthStr = "Bearer " + authToken;
            axios
                .get("api/qr-code?" + urlEndPoint, {
                    headers: { Authorization: AuthStr },
                })
                .then((response) => {
                    this.response =
                        "data:image/png;base64," + response.data.qr_code;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    mounted() {
        console.log("Component mounted User.");
        let authToken = localStorage.getItem("qrCodeToken");

        if (authToken == null) {
            this.$router.push("/login");
        }
    },

    validations() {
        return {
            size: {
                required,
                minLength: minLength(1),
                maxLength: maxLength(3),
                numeric,
            },
            content: {
                required,
                minLength: minLength(3),
                maxLength: maxLength(20),
            },
        };
    },
};
</script>

<style lang="scss" scoped>
.card {
    --bs-card-height: 100% !important;
}
.lineHeight {
    padding: 20px;
}

.titleQr {
    padding-top: 20px;
}

.row {
    width: 100% !important;
}
.row .imageHeader {
    background: #6565d9;
    padding: 10px 0px 10px 10px;
    border-radius: 15px;
}

img.finalImage {
    max-width: 50%;
    margin: 7em auto;
}

#cardLogin {
    border-radius: 15px;
    max-width: 100%;
    h1 {
        font-weight: 700;
    }
    // margin: 5em auto;
    #formLogin {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 20px;
        position: relative;

        h1 {
            font-weight: 700;
        }

        h2 {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .input {
            border-radius: 10px;
        }
    }

    .row.imageHeader {
        background-color: #45cbcb;
        padding: 10px 0px 10px 15px;
    }

    .form-group--error {
        color: red;
    }

    .form-group--error .form__label,
    .form-group--error .form__label--inline {
        color: #f04124;
    }

    .form-group--error input,
    .form-group--error input:focus,
    .form-group--error input:hover {
        border-color: red;
    }

    .error {
        color: red;
    }

    .hu-color-picker {
        width: 250px !important;
    }
}
</style>
