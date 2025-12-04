<template>
  <draggable class="dragArea ml-2" tag="ul" :list="menus" :group="{ name: 'g1' }" item-key="id">
      <template #item="{ element }">
          <li class="bg-white p-2 border border-gray-300 rounded cursor-move mt-2">
              <div class="flex justify-between items-center bg-gray-50 px-4 py-2 rounded-md">
                  <p class="text-base font-semibold leading-7 text-gray-900">
                      {{ element . name }}
                  </p>
                  <div class="flex justify-between space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer"
                        @click.prevent="updateCurrentId(element.id)" v-if="currnetItemId != element.id || currnetItemId == null">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer"
                        v-else @click.prevent="updateCurrentId(null)">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5-7.5 7.5 7.5m-15 6l7.5-7.5 7.5 7.5" />
                    </svg>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                          class="w-5 h-5 cursor-pointer" @click="deleteMenuItem(element.id)">
                          <path fill-rule="evenodd"
                              d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                              clip-rule="evenodd" />
                      </svg>
                  </div>
              </div>
              <div v-if="currnetItemId == element.id" class="border mt-2 rounded p-3 shadow">
                  <div class="grid md:grid-cols-1 md:gap-2">
                      <div class="relative z-0 w-full group mt-2">
                          <label for="link" class="block text-sm font-medium leading-6 text-gray-900">URL</label>
                          <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-600 sm:max-w-md">
                                <input type="text" name="link" id="link" class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 cursor-not-allowed" placeholder="" :value="element.link" @input="updateMenuItem(element, $event.target.value, 'link')"   :disabled="element.id !== null">
                            </div>
                      </div>
                      <div class="relative z-0 w-full group mt-2">
                          <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Page name</label>
                          <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-600 sm:max-w-md">
                            <input type="text" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="" :value="element.name" @input="updateMenuItem(element, $event.target.value, 'name')">
                          </div>
                      </div>
                  </div>
              </div>
              <nested-draggable :menus="element.menus" @update-menu="updateMenuItem" @delete-menu="deleteMenuItem" />
          </li>
      </template>
  </draggable>
</template>

  <script>
  import draggable from "vuedraggable";
  import { mapState } from "vuex";
  export default {
    computed: {
      ...mapState({
          currnetItemId: (state) => state.menus.currnetItemId,
      })
    },
    name:"nested-draggable",
    props:['menus'],
    created(){
      this.$store.commit('menus/setCurrentId', null)
    },
    methods:{
      updateCurrentId(currnetItemId){
        this.$store.commit('menus/setCurrentId', currnetItemId)
      },

    updateMenuItem(element, value, type){
      if(type == 'link'){
        this.$emit('updateMenu', element, value, type)
      }
      else if(type == 'name'){
        this.$emit('updateMenu', element, value, type)
      }
    },
    deleteMenuItem(id){
      this.$emit('deleteMenu', id)
      }
    },
    components: {
      draggable
    },
  };
  </script>
  <style scoped>
  .sortable-ghost {
    height: 35px !important;
  }
  .dragArea {
    min-height: 50px;
    /* min-height: 50px;
    outline: 1px dashed; */
  }
  </style>
