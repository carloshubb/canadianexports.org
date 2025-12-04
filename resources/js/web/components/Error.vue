<template>
    <div class="relative tooltip -bottom-4 group-hover:flex" v-if="validationErros.has(fieldName)">
        <div role="tooltip" class="relative tooltiptext -top-2 z-0 leading-none transition duration-150 ease-in-out shadow-lg py-2 pr-5 pl-3 bg-primary text-gray-600 rounded w-fit">
            <!-- Display error messages as a single block of text -->
            <span class="text-white leading-none py-2 text-base md:text-base lg:text-lg text-left">
                <span v-html="validationErros.get(fieldName)"></span>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['validationErros', 'fieldName', 'full_width'],
};
</script>
