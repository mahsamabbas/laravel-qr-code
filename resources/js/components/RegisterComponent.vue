// RegisterComponent

<template>
    <div>
        <b-card id="cardLogin" class="scale-in-bl">
            <b-form @submit.prevent="onSubmit" id="formLogin">
                <h1 class="text-center mb-3">Register User</h1>

                <b-row class="lineHeight">
                    <b-col md="12">
                        <div
                            class="lineHeight"
                            :class="{ 'form-group--error': $v.name.$error }"
                        >
                            <b-form-group id="input-group-1" label-for="name">
                                <b-form-input
                                    id="name"
                                    class="input"
                                    v-model="name"
                                    type="text"
                                    placeholder="Full Name"
                                ></b-form-input>
                            </b-form-group>
                        </div>
                        <div v-if="$v.name.$error">
                            <span class="error" v-if="!$v.name.required">
                                Required
                            </span>
                            <span class="error" v-if="!$v.name.minLength">
                                Minimum length must be 3
                            </span>
                            <span class="error" v-if="!$v.name.maxLength">
                                Max length must be less than 10
                            </span>
                            <span class="error" v-if="!$v.name.alpha">
                                Alphabets only
                            </span>
                        </div>

                        <div
                            class="lineHeight"
                            :class="{ 'form-group--error': $v.email.$error }"
                        >
                            <b-form-group id="input-group-1" label-for="email">
                                <b-form-input
                                    id="email"
                                    class="input"
                                    v-model="email"
                                    type="email"
                                    placeholder="E-mail"
                                ></b-form-input>
                            </b-form-group>
                        </div>
                        <div v-if="$v.email.$error">
                            <span class="error" v-if="!$v.email.required">
                                Required
                            </span>
                            <span class="error" v-if="!$v.email.minLength">
                                Minimum length must be 3
                            </span>
                            <span class="error" v-if="!$v.password.maxLength">
                                Max length must be less than 10
                            </span>
                            <span class="error" v-if="!$v.email.email">
                                must be an email
                            </span>
                        </div>

                        <div
                            class="lineHeight"
                            :class="{ 'form-group--error': $v.password.$error }"
                        >
                            <b-form-group
                                id="input-group-2"
                                label-for="input-2"
                            >
                                <b-form-input
                                    id="passord"
                                    class="input"
                                    v-model="password"
                                    placeholder="Password"
                                    type="password"
                                ></b-form-input>
                            </b-form-group>
                        </div>
                        <div v-if="$v.password.$error">
                            <span class="error" v-if="!$v.password.required">
                                Required
                            </span>
                            <span class="error" v-if="!$v.password.minLength">
                                Minimum length must be 6
                            </span>
                            <span class="error" v-if="!$v.password.maxLength">
                                Max length must be less than 10
                            </span>
                            <span
                                class="error"
                                v-if="!$v.name.passwordValidate"
                            >
                                Minimum eight characters, at least one letter,
                                one number and one special character
                            </span>
                        </div>

                        <div
                            :class="{
                                'form-group--error': $v.confirmpassword.$error,
                            }"
                            class="lineHeight"
                        >
                            <b-form-group
                                id="input-group-2"
                                label-for="input-2"
                            >
                                <b-form-input
                                    id="confirmpassword"
                                    class="input"
                                    v-model="confirmpassword"
                                    placeholder="Confirm Password"
                                    type="password"
                                ></b-form-input>
                            </b-form-group>
                        </div>
                        <div v-if="$v.confirmpassword.$error">
                            <span
                                class="error"
                                v-if="!$v.confirmpassword.required"
                            >
                                Required
                            </span>
                            <span
                                class="error"
                                v-if="!$v.confirmpassword.minLength"
                            >
                                Minimum length must be 6
                            </span>
                            <span
                                class="error"
                                v-if="!$v.confirmpassword.maxLength"
                            >
                                Max length must be less than 10
                            </span>
                            <span
                                class="error"
                                v-if="!$v.name.passwordValidate"
                            >
                                Minimum eight characters, at least one letter,
                                one number and one special character
                            </span>
                        </div>
                        <div v-if="confirmerror">
                            <span class="error"> {{ confirmerror }} </span>
                        </div>
                    </b-col>
                </b-row>

                <div class="d-flex justify-content-center mt-3">
                    <span class="error" v-if="error">
                        {{ error }}
                    </span>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <b-button
                        type="submit"
                        variant="outline-primary"
                        class="buttonSizeAll"
                        >Register</b-button
                    >
                </div>

                <div
                    class="d-flex justify-content-center flex-wrap mt-4 register"
                >
                    <span class="mr-2">Already have an account ?</span>
                    <router-link to="/login" class="createAccount"
                        >Login
                    </router-link>
                </div>
            </b-form>
        </b-card>
    </div>
</template>

<script>
import {
    required,
    minLength,
    maxLength,
    email,
    helpers,
} from "vuelidate/lib/validators";
const alpha = helpers.regex("alpha", /^[a-zA-Z ]*$/);
const passwordValidate = helpers.regex(
    "passwordValidate",
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.,/])[A-Za-z\d@$!%*#?&.,/]{6,20}$/
);

export default {
    name: "RegisterComponent",
    data() {
        return {
            name: "",
            email: "",
            password: "",
            confirmpassword: "",
            error: "",
            confirmerror: "",
            validatePassword: true,
        };
    },
    methods: {
        async onSubmit() {
            this.$v.$touch();
            if (this.$v.$invalid || !this.validatePassword) {
                console.log("Form validation error");
                return false;
            }

            const AuthStr = await this.apiClient();
            let data = new FormData();
            data.append("name", this.name);
            data.append("email", this.email);
            data.append("password", this.password);
            data.append("password_confirm", this.confirmpassword);

            axios
                .post("api/register", data, {
                    headers: { Authorization: AuthStr },
                })
                .then((response) => {
                    if (response.data.status == 200) {
                        localStorage.setItem(
                            "qrCodeToken",
                            response.data.token
                        );
                        this.$router.push("/qr");
                    } else if (response.data.status == 401) {
                        this.error = response.data.error.email[0];
                    } else {
                        this.error = response.data.message;
                    }
                })
                .catch((error) => {
                    const emailError =
                        typeof error.response.data.errors.email != "undefined"
                            ? error.response.data.errors.email[0]
                            : "";
                    const passwordError =
                        typeof error.response.data.errors.password !=
                        "undefined"
                            ? error.response.data.errors.password[0]
                            : "";
                    const confirmPasswordError =
                        typeof error.response.data.errors.password_confirm !=
                        "undefined"
                            ? error.response.data.errors.password_confirm[0]
                            : "";

                    // error.response.data.message +
                    this.error =
                        emailError + passwordError + confirmPasswordError;
                });
        },
    },
    watch: {
        confirmpassword() {
            if (this.password !== this.confirmpassword) {
                this.confirmerror =
                    "Confirm Password didn't match the password";
                this.validatePassword = false;
            } else {
                this.confirmerror = "";
                this.validatePassword = true;
            }
        },
    },
    mounted() {
        this.userVerification();
    },
    validations() {
        return {
            name: {
                required,
                minLength: minLength(3),
                maxLength: maxLength(100),
                alpha,
            },
            email: {
                required,
                minLength: minLength(3),
                maxLength: maxLength(50),
                email,
            },
            password: {
                required,
                minLength: minLength(6),
                maxLength: maxLength(20),
                passwordValidate,
            },
            confirmpassword: {
                required,
                minLength: minLength(6),
                maxLength: maxLength(20),
                passwordValidate,
            },
        };
    },
};
</script>

<style lang="scss" scoped>
.lineHeight {
    padding: 20px;
}

#cardLogin {
    border-radius: 15px;
    max-width: 600px;
    margin: 5em auto;

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
}
</style>
