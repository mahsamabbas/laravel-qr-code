<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="primary">
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <!-- Right aligned nav items -->
                <b-navbar-nav class="dropDownButtons">
                    <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                        <template #button-content>
                            <em style="color: black">{{ username }}</em>
                        </template>
                        <b-dropdown-item href="#" @click="signOut"
                            >Sign Out</b-dropdown-item
                        >
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>
<script>
export default {
    name: "NavbarComponent",
    data() {
        return {
            username: "",
        };
    },
    methods: {
        signOut() {
            localStorage.removeItem("qrCodeToken");
            this.$router.push("/");
        },
    },
    mounted() {
        this.username = localStorage.getItem("username");
    },
};
</script>
<style scoped>
.dropDownButtons {
    margin-left: 90%;
}
.dropdown-toggle::after {
    color: black !important;
}
</style>
