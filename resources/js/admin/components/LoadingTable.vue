<template>
    <tbody id="loading-table">
        <tr class="border-b border-gray-300  bg-blue-50 animate-pulse" v-for="n in 20" :key="n" :class="loading == true ? '' : 'hidden'">
            <td class="pl-3 w-24 py-3" v-if="1 <= columns">
                <div class="h-4 bg-gray-300 rounded w-5/6"></div>
                <div class="h-4 bg-gray-300 rounded mt-1"></div>
                <div class="h-4 bg-gray-300 rounded mt-1 w-5/6"></div>
            </td>
            <td class="whitespace-no-wrap" v-if="2 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 whitespace-no-wrap" v-if="3 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 whitespace-no-wrap" v-if="4 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
                <div class="h-4 bg-gray-300 rounded mt-1"></div>
            </td>
            <td class="pl-4 whitespace-no-wrap" v-if="5 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 whitespace-no-wrap" v-if="6 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="7 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="8 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="9 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="10 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="11 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="12 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="13 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="14 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="15 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="16 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="17 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="18 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="19 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
            <td class="pl-4 pr-4 whitespace-no-wrap" v-if="20 <= columns">
                <div class="h-4 bg-gray-300 rounded"></div>
            </td>
        </tr>
    </tbody>
    </template>
<script>
    export default {
        props:['loading', 'columns']
}
</script>    