<template>
  <AppLayout>
    <!-- Main content header -->
    <div class="md:flex md:items-center md:justify-between">
      <div class="min-w-0 flex-1 p-4 rounded h-screen">
          <div class="mb-4 flex flex-col sm:flex-col md:flex-row lg:flex-row items-center justify-between gap-4">
            <h3 class="can-exp-h3 text-primary text-center sm:text-left">
              Dashboard
            </h3>
            <!-- Add the button here -->
            <div class="">
              <a
              href="/cron-job/holiday-emails"
              target="_blank"
                class="button-exp-fill bg-blue-500 hover:bg-blue-600 block"
              >
                Send Holiday Emails
              </a>
            </div>
          </div>
        <div class="mb-8">
          <ul
            role="list"
            class="mt-3 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4"
          >
            <li class="col-span-1 flex rounded-md shadow-sm">
              <div
                class="group w-full max-w-sm rounded-lg border-b-2 border-blue-400 bg-white p-4 shadow-md transition duration-300 hover:border-blue-600 hover:shadow-lg"
              >
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-2">
                    <div class="rounded-lg bg-blue-400 p-2 text-white">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"
                        />
                      </svg>
                    </div>
                    <p class="text-3xl font-semibold text-gray-800">{{stats?.['business_profiles']}}</p>
                  </div>
                </div>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">Business profiles</p>
                </div>
              </div>
            </li>
            <li class="col-span-1 flex rounded-md shadow-sm">
              <div
                class="group w-full max-w-sm rounded-lg border-b-2 border-green-400 bg-white p-4 shadow-md transition duration-300 hover:border-green-600 hover:shadow-lg"
              >
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-2">
                    <div class="rounded-lg bg-green-400 p-2 text-white">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"
                        />
                      </svg>
                    </div>
                    <p class="text-3xl font-semibold text-gray-800">{{stats?.['featured_exporters']}}</p>
                  </div>
                </div>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">Featured exporters</p>
                </div>
              </div>
            </li>
            <li class="col-span-1 flex rounded-md shadow-sm">
              <div
                class="group w-full max-w-sm rounded-lg border-b-2 border-yellow-400 bg-white p-4 shadow-md transition duration-300 hover:border-yellow-600 hover:shadow-lg"
              >
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-2">
                    <div class="rounded-lg bg-yellow-400 p-2 text-white">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"
                        />
                      </svg>
                    </div>
                    <p class="text-3xl font-semibold text-gray-800">{{stats?.['i2b']}}</p>
                  </div>
                </div>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">Inquries to buy</p>
                </div>
              </div>
            </li>
            <li class="col-span-1 flex rounded-md shadow-sm">
              <div
                class="group w-full max-w-sm rounded-lg border-b-2 border-cyan-400 bg-white p-4 shadow-md transition duration-300 hover:border-cyan-600 hover:shadow-lg"
              >
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-2">
                    <div class="rounded-lg bg-cyan-400 p-2 text-white">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"
                        />
                      </svg>
                    </div>
                    <p class="text-3xl font-semibold text-gray-800">{{stats?.['users']}}</p>
                  </div>
                </div>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">Registered Users</p>
                </div>
              </div>
            </li>
          </ul>
        </div>

        <div>
          <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <h2
              class="mx-auto max-w-2xl text-3xl font-semibold leading-6 text-gray-900 lg:mx-0 lg:max-w-none"
            >
              Recent activity
            </h2>
          </div>
          <div class="mt-6 overflow-hidden border-t border-gray-100">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
              <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                <table class="w-full text-left">
                  <thead class="sr-only">
                    <tr>
                      <th>Amount</th>
                      <th>Client</th>
                      <th>More details</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr class="text-sm leading-6 text-gray-900">
                          <th scope="colgroup" colspan="4" class="relative isolate py-2 font-semibold">
                              Latest profiles
                              <div class="absolute inset-y-0 right-full -z-10 w-screen border-b border-gray-200 bg-gray-50"></div>
                              <div class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-gray-200 bg-gray-50"></div>
                          </th>
                      </tr>
                      <tr v-for="order in stats?.orders" :key="order?.id + order?.status">
                          <td class="relative py-5 pr-6">
                              <div class="flex gap-x-6">
                                  <div class="flex-auto">
                                      <div class="flex items-start gap-x-3">
                                          <div class="text-sm font-medium leading-6 text-gray-900">
                                              ${{ order?.amount }} USD
                                          </div>
                                          <div class="rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset text-green-700 bg-green-50 ring-green-600/20">
                                              {{ order?.registration_package?.type }}
                                          </div>
                                          <div v-if="order?.status === 'deleted'" class="rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset text-red-700 bg-red-50 ring-red-600/20">
                                              Deleted
                                          </div>
                                          <div v-else class="rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset text-blue-700 bg-blue-50 ring-blue-600/20">
                                              Created
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100"></div>
                              <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100"></div>
                          </td>
                          <td class="hidden py-5 pr-6 sm:table-cell">
                              <div class="text-sm leading-6 text-gray-900">
                                  {{ order?.customer?.name }}
                              </div>
                          </td>
                          <td class="hidden py-5 pr-6 sm:table-cell">
                              <div class="text-sm leading-6 text-gray-900">
                                  {{ order?.customer?.email }}
                              </div>
                          </td>
                          <td class="py-5 text-right">
                              <div class="mt-1 text-xs leading-5 text-gray-500">
                                  {{ order?.registration_package?.package_type }}
                              </div>
                          </td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
<script>
export default {
  data() {
    return {
      stats: null,
    };
  },
  methods: {
    // triggerHolidayEmails() {
    //   let url =  'process.env.MIX_ADMIN_API_URL + /cron-job/holiday-emails';
    //   axios
    //     .get(url)
    //     .then((res) => {
    //       if (res.data) {
    //         this.$swal.fire(
    //           "Success!",
    //           "Holiday emails have been sent successfully.",
    //           "success"
    //         );
    //       }
    //     })
    //     .catch((error) => {
    //       this.$swal.fire(
    //         "Error!",
    //         error.response?.data?.message || "Failed to send holiday emails.",
    //         "error"
    //       );
    //     });
    // },
    fetchDashboardStats() {
      let url = `${process.env.MIX_ADMIN_API_URL}dashboard-stats`;
      axios.get(url).then((res) => {
        if (res.data.status == "Success") {
            console.log(res.data.data);
            this.stats = res.data.data;
        }
      });
    },
  },
  created() {
    this.fetchDashboardStats();
  },
};
</script>
