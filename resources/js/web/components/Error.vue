<template>
    <div class="relative mt-2" v-if="validationErros.has(fieldName)" :data-error-field="fieldName">
        <div role="tooltip" class="relative tooltiptext z-50 leading-none transition duration-150 ease-in-out shadow-lg py-2 px-3 bg-primary text-gray-600 rounded w-fit inline-block">
            <!-- Arrow pointing upward to the label -->
            <div class="absolute -top-2 z-50" :class="arrowPosition">
                <svg width="16" height="8" viewBox="0 0 16 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 0L0 8H16L8 0Z" fill="#006EB7" class="arrow-fill"/>
                </svg>
            </div>
            <!-- Display generic error message -->
            <span class="text-white leading-none py-1 text-base md:text-base lg:text-lg text-left block">
                This field is required
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['validationErros', 'fieldName', 'full_width', 'arrowAlign'],
    computed: {
        arrowPosition() {
            // Determine arrow position: left, center, or right
            // Default to center if not specified
            const align = this.arrowAlign || 'center';
            
            if (align === 'left') {
                return 'left-3';
            } else if (align === 'right') {
                return 'right-3';
            } else {
                // center (default)
                return 'left-1/2 transform -translate-x-1/2';
            }
        }
    }
};
</script>

<style scoped>
.tooltiptext {
    animation: fadeIn 0.2s ease-in;
}

.arrow-fill {
    fill: #006EB7;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
