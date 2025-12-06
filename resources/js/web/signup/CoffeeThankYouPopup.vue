<template>
    <div v-if="isVisible" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="closePopup"></div>

            <!-- Center modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 w-full">
                            <!-- Title Section -->
                            <h3 class="text-2xl leading-6 font-bold text-gray-900 mb-4" id="modal-title">
                                Your Coffee Is on Someone Today ☕💛
                            </h3>
                            
                            <!-- Text Section -->
                            <div class="mt-4">
                                <p class="text-lg text-gray-700">
                                    This Coffee comes from <span class="font-semibold text-primary">{{ donorName }}</span>, who chose to support Canadian small businesses like yours.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Button Section -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button 
                        type="button" 
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-xblue via-primary to-blue-600 text-base font-medium text-white hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm"
                        @click="closePopup"
                    >
                        Thank you
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isVisible: {
            type: Boolean,
            default: false
        },
        donorName: {
            type: String,
            default: 'A Kind Supporter'
        }
    },
    methods: {
        closePopup() {
            this.$emit('close');
        }
    }
}
</script>

<style scoped>
/* Optional: Add custom styles if needed */
.text-primary {
    color: #1e40af; /* Adjust to match your primary color */
}

.from-xblue {
    /* Adjust to match your xblue color */
}
</style>