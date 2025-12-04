<template>
    <div class="grid grid-cols-1 gap-12 container">
        <div class="order-2 md:order-1">
            <div class="mt-8 flex justify-center items-center">
                <a
                    aria-label="Candian Exporters"
                    class="button-exp-fill cursor-pointer"
                    @click.prevent="displayDeleteProfile()"
                >
                    {{
                        JSON.parse(close_acc_setting) ? JSON.parse(close_acc_setting)["button_text"] : ""
                    }}
                </a>
            </div>
        </div>
    </div>
</template>
<script>
import swal from "sweetalert2";
import axios from "axios";
export default {
    props: ["close_acc_setting", "submit_url", "popup_setting"],
    methods: {
        displayDeleteProfile() {
            swal.fire({
                title: this.popup_setting && JSON.parse(this.popup_setting) && JSON.parse(this.popup_setting)['message_30'] ? JSON.parse(this.popup_setting)['message_30'] : "",
                html: "<p class='text-center'>"+(this.popup_setting && JSON.parse(this.popup_setting) && JSON.parse(this.popup_setting)['message_31'] ? JSON.parse(this.popup_setting)['message_31'] : "")+"</p>",
                icon: "warning",
                buttonsStyling: false,
                customClass: {
                title: "swalSuccessClass",
                htmlContainer: "swalSuccessClass",
                confirmButton: 'button-exp-fill mr-2 hover:bg-blue-500 focus:outline-none',
                cancelButton: 'button-exp-no-fill bg-red-500 text-white hover:bg-red-400 border-none hover:text-white focus:outline-none',
            },
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: this.popup_setting && JSON.parse(this.popup_setting) && JSON.parse(this.popup_setting)['message_32'] ? JSON.parse(this.popup_setting)['message_32'] : "",
                cancelButtonText: this.popup_setting && JSON.parse(this.popup_setting) && JSON.parse(this.popup_setting)['message_33'] ? JSON.parse(this.popup_setting)['message_33'] : ""
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteProfile();
                }
            });
        },
        deleteProfile() {
            axios.post(this.submit_url).then((res) => {
                if (res.data.status == "Success") {
                    helper.swalSuccessMessageForWeb(res.data.message);
                    setTimeout(() => {
                        window.location.href = res.data.data.redirect_url;
                    }, 2000);
                } else {
                    helper.swalErrorMessageForWeb(res.data.message);
                }
            });
        },
    },
};
</script>
