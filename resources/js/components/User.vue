<template>
    <div>
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
                                        placeholder="500"
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
                                        placeholder="Mvix USA"
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
                            <b-button type="submit" variant="outline-primary"
                                >Get Qr</b-button
                            >
                        </div>
                    </b-form>
                </b-card>
            </b-col>
            <b-col md="6">
                <!-- <b-row class=""> -->
                 <img :src="response" class="finalImage"></img>
                <!-- </b-row> -->
            </b-col>
        </b-row>
    </div>
</template>

<script>
import colorPicker from "@caohenghu/vue-colorpicker";

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
            content: "Mvix USA",
            size: 500,
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
                this.color +
                "/" +
                this.content +
                "/" +
                this.size +
                "/" +
                this.colorFill;

            let authToken = localStorage.getItem("qrCodeToken");

            if (authToken == null) {
                return;
            }
            const AuthStr = "Bearer " + authToken;
            axios
                .get("api/qr-code/" + urlEndPoint, {
                    headers: { Authorization: AuthStr },
                })
                .then((response) => {
                    console.log(response);
                    // console.log(response.data);
                    // console.log(response.data.qr-code);
                    this.response = response.data.qr_code;
                    // this.response = "data:image/jpeg;base64,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";
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

<style lang="scss">
.lineHeight {
    padding: 20px;
}

#cardLogin {
    border-radius: 15px;
    //   box-shadow: 0px 0px 10px $gray;

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
    img.finalImage {
    margin: 274px 443px;
}
}
</style>
