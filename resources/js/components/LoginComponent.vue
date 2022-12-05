<template>
  <div>

    <b-card id="cardLogin" class="scale-in-bl">
      <b-form @submit.prevent="onSubmit" id="formLogin">
        <h1 class="text-center mb-3">Login</h1>
        <!-- <b-img src="../assets/images/logo.png" fluid class="logoLogin mb-4" /> -->
        <b-row class="lineHeight">

          <b-col md="4"></b-col>
          <b-col md="4">

          <div :class="{ 'form-group--error': $v.email.$error }">
            <b-form-group id="input-group-1" label-for="email" class="lineHeight">
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
            <span class="error" v-if="!$v.email.required"> Required </span>
            <span class="error" v-if="!$v.email.minLength">
              Minimum length must be 3
            </span>
            <span class="error" v-if="!$v.password.maxLength">
              Max length must be less than 10
            </span>
            <span class="error" v-if="!$v.email.email"> must be an email </span>
          </div>
        
          <div :class="{ 'form-group--error': $v.password.$error }" class="lineHeight">
            <b-form-group id="input-group-2" label-for="input-2">
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
            <span class="error" v-if="!$v.password.required"> Required </span>
            <span class="error" v-if="!$v.password.minLength">
              Minimum length must be 3
            </span>
            <span class="error" v-if="!$v.password.maxLength">
              Max length must be less than 20
            </span>
          </div>

        </b-col>
          <b-col md="4"></b-col>
         
        </b-row>

        <div class="d-flex justify-content-center mt-3">
          <span class="error" v-if="error">
            {{ error }}
          </span>
        </div>
        <div class="d-flex justify-content-center mt-3">
          <b-button type="submit" class="buttonSizeAll" variant="outline-primary">Login</b-button>
        </div>

        <div class="d-flex justify-content-center flex-wrap mt-4 register">
          <span class="mr-2">Don't have an account ?</span>
          <router-link to="/register" class="createAccount"
            >Register
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
} from "vuelidate/lib/validators";

export default {
  name: "LoginComponent",
  data() {
    return {
      email: "",
      password: "",
      error: "",
    };
  },
  methods: {
    onSubmit() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        return false;
      }
      let data = new FormData();
      data.append("email", this.email);
      data.append("password", this.password);

      axios
        .post("api/login", data, {
          headers: {},
        })
        .then((response) => {
          if (response.data.status == 200) {
            console.log(response.data.token);
            localStorage.setItem("qrCodeToken", response.data.access_token);
            localStorage.setItem("username", this.email);
            this.$router.push("/qr");
          } else if (response.data.status == 401) {
            this.error = response.data.error.password[0];
          } else {
            this.error = response.data.message;
          }
        })
        .catch((error) => {
          console.log("in catch");
        });
    },
  },

  mounted() {
    this.userVerification();
  },

  validations() {
    return {
      email: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(50),
        email,
      },
      password: { required, minLength: minLength(3), maxLength: maxLength(20) },
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
}
</style>
