<template>
  <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded min-h-[50vh]"
    :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']">
    <div class="rounded-t mb-0 px-4 py-3 border-0">
      <div class="flex flex-wrap items-center">
        <div class="relative w-full  max-w-full flex-grow flex-1">
          <h3 class="font-semibold text-lg" :class="[color === 'light' ? 'text-blueGray-700' : 'text-white']">
            {{ namaTitle }}
          </h3>
        </div>
        <div class=" relative md:w-full md:max-w-full flex-grow flex-1 text-right">
          <slot name="button" />
        </div>
      </div>
      <div class="flex flex-wrap items-center">
        <slot name="pencarian"/>
        </div>
    </div>
    <div class="block w-full overflow-x-auto">
      <!-- Projects table -->
      <table class="items-center w-full bg-transparent border-collapse">
        <thead>
          <tr>
            <th v-for="(data, index) in header"
              class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
              :class="[
                color === 'light'
                  ? 'bg-blueGray-50 text-blueblue-300 border-blueGray-100'
                  : 'bg-emerald-800 text-emerald-300 border-emerald-700',
                'text-' + data.align
              ]">
              {{ data.title }}
            </th>
          </tr>
        </thead>
        <tbody>
          <template v-if="list.length < 1">
              <tr class=" border-gray-200  ">
                <td  class="border-t-0 px-6 align-middle text-center border-l-0 border-r-0 text-s text-slate-500 whitespace-nowrap pt-20" 
                :colspan="header.length"> Tidak Ada Data Yang Ditampilkan</td>
              </tr>
              
            </template>
          <template v-for="( data, index ) in list">
            <tr class="border-b border-gray-200  ">
              <template v-for="(datax, index) in header">
                <template v-if="datax.type == 'gambar'">
                  <th
                    class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left flex items-center">
                    <img :src="datax.baseurl + data[datax.fieldfoto]" @error="$event.target.src = image"
                      class="h-12 w-12 bg-white rounded-full border" alt="...">
                    <span class="ml-3 font-bold text-blueGray-600"> {{ data[datax.fieldtext] ? data[datax.fieldtext] : '-'
                    }} </span>
                  </th>
                </template>
                <template v-else-if="datax.type == 'costum'">
                  <td
                  class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-s text-slate-500 whitespace-nowrap p-2"
                  :class="['text-' + datax.align, 'w-' + datax.size]">
                    <template v-for="(item, index) in datax.data">
                      
                      <button v-if="item.type === 'button'"
                        type="button"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-grey-700 bg-transparent border shadow transition ease-in-out duration-150" 
                        v-on:click="klik(data,item.action)"
                        :class="item.class">
                        <span>
                          <i :class="item.icon"></i>
                          {{ item.text }}
                        </span>
                      </button>

                    </template>
                  </td>
                </template>
                <template v-else-if="datax.type == 'url'">
                  <td
                  class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-s text-slate-500 whitespace-nowrap p-2"
                  :class="['text-' + datax.align, 'w-' + datax.size]">
                    <a :href="data[datax.field]" target="_blank" class="text-green-400"><u>{{wrapText(data[datax.field] ? data[datax.field] : '-') }}</u></a>
                  </td>
                </template>
                <template v-else-if="datax.type == 'datetime'">
                  <td
                  class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-s text-slate-500 whitespace-nowrap p-2"
                  :class="['text-' + datax.align, 'w-' + datax.size]">
                  {{formattedDate (data[datax.field])}}
                  </td>
                </template>
                
                <template v-else-if="datax.type == 'button-group'">
                  <td
                  class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-s text-slate-500 whitespace-nowrap p-2"
                  :class="['text-' + datax.align, 'w-' + datax.size]">
                  <div class=" inline-flex " role="group">
                    <template v-for="(item, index) in datax.data">
                      
                      <button 
                        type="button"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium shadow-md text-grey-700 bg-transparent  transition ease-in-out duration-150" 
                        v-on:click="klik(data,item.action)"
                        :class="item.class">
                        <span>
                          <i :class="item.icon"></i>
                          {{ item.text }}
                        </span>
                      </button>
                      
                    </template>
                  </div>
                  
                  </td>
                </template>
                <template v-else>
                  <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-s text-slate-500 whitespace-nowrap p-2 "
                    :class="['text-' + datax.align, 'w-' + datax.size +' '+ datax.class]">
                    <div v-if="datax.type == 'string' || datax.type == 'Text'">
                      {{ data[datax.field] ? data[datax.field] : '-' }}
                    </div>

                    <div v-else-if="datax.type == 'button-edit-delete'">
                      <div class=" inline-flex rounded-md shadow-sm " role="group">
                        <button type="button" v-on:click="clickedit(data)"
                          class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-blue-500 rounded-l-lg
                      shadow transition ease-in-out duration-150  
                      hover:bg-blue-500 hover:text-white 
                      focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]
                      dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                          <i class="fas fa-lg fa-pencil-alt"></i>
                        </button>
                      
                        <button type="button" v-on:click="clickhapus(data)"
                          class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-500 bg-transparent border border-red-500 rounded-r-md 
                      shadow transition ease-in-out duration-150  
                      hover:bg-red-500 hover:text-white
                      focus:outline-none focus:ring-2 focus:ring-red-700 focus:bg-red-500 focus:text-white 
                      dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-red-700 dark:focus:bg-red-700">
                          <i class="fas fa-lg fa-trash-alt"></i>
                        </button>
                      </div>
                    </div>


                  </td>
                </template>


              </template>

            </tr>

          </template>



        </tbody>

      </table>

    </div>
  </div>
</template>
<script>

import image from "@/img/no-image.png";
import { Link } from "@inertiajs/vue3";
import moment from 'moment';
export default {

  emits: ['clickhapus','klik'],
  data() {

    return {
      image: image,
      status: false
    };
  },
  components: {
    Link,
    moment
},
  props: {
    color: {
      default: "light",
      validator: function (value) {
        // The value must match one of these strings
        return ["light", "dark"].indexOf(value) !== -1;
      },
    },
    list: {},
    header: Array,
    namaTitle: String

  },
  methods: {
    onClickChild(value) {
      this.status = value
    },
    clickedit(value) {
      this.$emit('clickedit', value);
    },
    clickhapus() {
      this.$emit('clickhapus');
    },
    klik(value,action){
      this.$emit('klik', {
        value : value,
        action : action
      });
    },
    wrapText(teks) {
      if (teks.length > 40) {
        return teks.substring(0, 40) + '...';
      }else{
        return teks;
      }
    
  },
  formattedDate(val) {
      return moment(val).format('HH:mm:ss DD-MM-YYYY');
    }

  }
};
</script>
