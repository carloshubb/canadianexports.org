<template>
    
</template>

<script>
export default {
    props: ["type", 'message'],
    created() {
        if(this.type == 'success'){
            helper.swalSuccessMessageForWeb(this.message)
        }
        else if(this.type == 'pre_success'){
            helper.swalPreSuccessMessageForWeb(this.message)
        }
        else if(this.type == 'error'){
            helper.swalErrorMessageForWeb(this.message)
        }
    },
};
</script>
