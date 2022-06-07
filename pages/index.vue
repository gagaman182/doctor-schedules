<template>
  <v-row>
    <v-col cols="12">
      <v-layout class="justify-center">
        <v-flex xs12>
          <v-card color="white">
            <v-alert
              color="#39AEA9"
              dark
              icon="mdi-clipboard-text-clock "
              border="left"
              prominent
              elevation="2"
              outlined
              tile
            >
              <div
                class="
                  white-text
                  pa-2
                  text-h4
                  animate__animated animate__headShake
                "
                outlined
                tile
              >
                {{ opddate_now }}
              </div>
            </v-alert>
          </v-card>
        </v-flex>
      </v-layout>

      <!-- <v-alert border="left" colored-border color="#7CB342" elevation="2">
          <div
            class="white-text pa-2 text-h4 animate__animated animate__headShake"
            outlined
            tile
          >
            {{ opddate_now }}
          </div>
        </v-alert> -->

      <v-card>
        <v-card-title class="text-h4 red--text mt-0 pt-0">
          <!-- Emergency Room -->
          แผนกอุบัติเหตุและฉุกเฉิน
          <v-icon class="text-h3 mb-2 red--text">mdi-car-emergency </v-icon>
          <v-switch
            class="mb-2 pt-5 ml-2"
            v-model="ershow"
            :label="ershow_text"
            inset
            @change="erchange"
          ></v-switch>
          <!-- <div class="ml-4 mt-2 text-h6 blue--text">
            ประเภทผู้ใช้งาน:{{ user }}
          </div> -->
          <v-row align="center" justify="end">
            <v-icon class="mr-2"> mdi-account-star </v-icon>
            <span class="text-h6 blue--text mr-2">ประเภทผู้ใช้งาน</span>
            <span class="mr-2 blue--text">:</span>
            <!-- <v-icon class="mr-1"> mdi-account-details-outline </v-icon> -->
            <span class="text-h5 green--text">{{ user }}</span>
          </v-row>
          <div class="ml-1" v-show="authenticated">
            <v-tooltip bottom color="red">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  @click="logout()"
                  plain
                  class="text-h6"
                  v-bind="attrs"
                  v-on="on"
                  ><v-icon color="red" large>mdi-location-exit </v-icon></v-btn
                >
              </template>
              <span>ออกจากระบบ</span>
            </v-tooltip>
          </div>
          <v-spacer />

          <div class="pr-2 mt-7">
            <v-menu
              v-model="menu"
              :close-on-content-click="false"
              max-width="290"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  solo
                  :value="computedDateFormattedMomentjs"
                  outlined
                  dense
                  prepend-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                  class="text-h6 text-green"
                ></v-text-field>
                <!-- @click:clear="datestart = null" -->
                <!-- clearable ปุ่ม กากบาท -->
              </template>
              <v-date-picker
                locale="th-TH"
                v-model="datestart"
                @change="date_select()"
                color="#069A8E"
              >
                <!-- @change="menu = false" กรณีไม่ใช้ปุ่มกด ใส่ใน v-date-picker -->
                <v-spacer></v-spacer>

                <!-- <v-btn text color="#069A8E" @click="menu = false"> ตกลง </v-btn> -->
              </v-date-picker>
            </v-menu>
          </div>
          <div class="pr-2">
            <v-tooltip bottom color="#F8B400" v-if="ershow">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  class="white--text"
                  x-large
                  color="#F8B400"
                  @click="refresh"
                  v-bind="attrs"
                  v-on="on"
                >
                  <v-icon>mdi-refresh-circle </v-icon>
                </v-btn>
              </template>
              <span>รีเฟรชหน้าจอ</span>
            </v-tooltip>
          </div>
          <v-tooltip bottom color="#069A8E" v-if="ershow">
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                class="white--text"
                x-large
                color="#069A8E"
                @click="open_er_dialog"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon>mdi-calendar-plus </v-icon>
              </v-btn>
            </template>
            <span>เพิ่มข้อมูล</span>
          </v-tooltip>
        </v-card-title>
        <!-- <v-divider /> -->

        <v-card-text v-show="ershow">
          <v-row>
            <v-col cols="12" sm="4" v-if="showdashboard" class="mt-0 pt-0">
              <Morning_shift
                class="mt-0 mb-0 pb-0"
                :datestart="datestart"
                ref="datechange_morning"
                v-if="renderComponent"
                @rerenderparent="reredereditparent"
                @calllogin="call_login"
                :session="session"
                :authenticated="authenticated"
            /></v-col>
            <v-col cols="12" sm="4" v-else class="mt-0 pt-0">
              <v-skeleton-loader
                class="mx-auto"
                max-width="300"
                type="card"
              ></v-skeleton-loader>
            </v-col>
            <v-col cols="12" sm="4" v-if="showdashboard" class="mt-0 pt-0">
              <Afternoon_shift
                class="mt-0 mb-0 pb-0"
                :datestart="datestart"
                ref="datechange_afternoon"
                v-if="renderComponent"
                @rerenderparent="reredereditparent"
                @calllogin="call_login"
                :session="session"
                :authenticated="authenticated"
              />
            </v-col>
            <v-col cols="12" sm="4" v-else class="mt-0 pt-0">
              <v-skeleton-loader
                class="mx-auto"
                max-width="300"
                type="card"
              ></v-skeleton-loader>
            </v-col>
            <v-col cols="12" sm="4" v-if="showdashboard" class="mt-0 pt-0">
              <Night_shirt
                class="mt-0 mb-0 pb-0"
                :datestart="datestart"
                ref="datechange_night"
                v-if="renderComponent"
                @rerenderparent="reredereditparent"
                @calllogin="call_login"
                :session="session"
                :authenticated="authenticated"
            /></v-col>
            <v-col cols="12" sm="4" v-else class="mt-0 pt-0">
              <v-skeleton-loader
                class="mx-auto"
                max-width="300"
                type="card"
              ></v-skeleton-loader>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
      <v-card>
        <v-card-title class="text-h4 blue--text mt-0 pt-0">
          <!-- Other Departments -->
          แผนกอื่นๆ

          <v-icon class="text-h3 mb-2" color="blue"
            >mdi-hospital-building
          </v-icon>
          <v-switch
            class="mb-2 pt-5 ml-2"
            v-model="dpshow"
            :label="dpshow_text"
            inset
            @change="dpchange"
          ></v-switch>
          <v-spacer />
          <div class="pr-2">
            <v-tooltip bottom color="#F8B400" v-if="dpshow">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  class="white--text"
                  x-large
                  color="#F8B400"
                  @click="refresh"
                  v-bind="attrs"
                  v-on="on"
                >
                  <v-icon>mdi-refresh-circle </v-icon>
                </v-btn>
              </template>
              <span>รีเฟรชหน้าจอ</span>
            </v-tooltip>
          </div>
          <v-tooltip bottom color="#069A8E" v-if="dpshow">
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                class="white--text"
                x-large
                color="#069A8E"
                @click="open_dp_dialog"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon>mdi-calendar-plus </v-icon>
              </v-btn>
            </template>
            <span>เพิ่มข้อมูล</span>
          </v-tooltip>
        </v-card-title>
        <!-- <v-divider /> -->

        <v-card-text v-show="dpshow">
          <v-row>
            <v-col cols="12" sm="12" class="mt-0 pt-0">
              <!-- <v-autocomplete
                :items="departments"
                v-model="department"
                item-text="name"
                item-value="name"
                label="แผนก"
                dense
                rounded
                outlined
                color="#069A8E"
                @change="depart_select()"
              ></v-autocomplete> -->
              <h3 class="ml-2 mb-2 title">เลือกแผนกที่จะแสดงข้อมูล</h3>
              <v-select
                :items="departments"
                v-model="department"
                item-text="name"
                item-value="name"
                label="แผนก"
                dense
                rounded
                outlined
                color="#069A8E"
                @change="depart_select()"
              ></v-select>
            </v-col>
            <v-col cols="12" sm="6" v-if="showdashboard" class="pt-0"
              ><Other_morning
                class="pt-0"
                :datestart="datestart"
                ref="usedepartin"
                v-if="renderComponent"
                @rerenderparent="reredereditparent"
                @calllogin="call_login"
                :session="session"
                :authenticated="authenticated"
            /></v-col>
            <v-col cols="12" sm="6" v-else>
              <v-skeleton-loader
                class="mx-auto"
                max-width="300"
                type="card"
              ></v-skeleton-loader>
            </v-col>
            <v-col cols="12" sm="6" v-if="showdashboard" class="pt-0"
              ><Other_night
                :datestart="datestart"
                ref="usedepartout"
                v-if="renderComponent"
                @rerenderparent="reredereditparent"
                @calllogin="call_login"
                :session="session"
                :authenticated="authenticated"
            /></v-col>
            <v-col cols="12" sm="6" v-else>
              <v-skeleton-loader
                class="mx-auto"
                max-width="300"
                type="card"
              ></v-skeleton-loader>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
      <Add_schedule_er
        :dialog_er="dialog_er"
        @closedialog_er="close_er_dialog"
      />
      <Add_schedule_department
        :dialog_dp="dialog_dp"
        @closedialog_dp="close_dp_dialog"
      />
    </v-col>
    <v-col cols="auto">
      <v-dialog
        transition="dialog-bottom-transition"
        max-width="600"
        v-model="dialog_login"
      >
        <!-- <template v-slot:activator="{ on, attrs }">
          <v-btn color="primary" v-bind="attrs" v-on="on"
            >From the bottom</v-btn
          >
        </template> -->
        <template v-slot:default="dialog_login">
          <v-card class="elevation-12">
            <v-toolbar dark color="#069A8E">
              <v-toolbar-title>เข้าสู่ระบบ</v-toolbar-title>
              <v-spacer />
              <v-btn
                class="mx-2"
                fab
                dark
                small
                color="red"
                @click="close_login()"
              >
                <v-icon dark> mdi-close </v-icon>
              </v-btn>
            </v-toolbar>

            <v-card-text>
              <v-form>
                <v-text-field
                  prepend-icon="mdi-account "
                  label="ชื่อเข้าใช้งาน"
                  type="text"
                  v-model="username"
                ></v-text-field>
                <v-text-field
                  prepend-icon="mdi-lock "
                  label="รหัสผ่าน"
                  type="password"
                  v-model="password"
                ></v-text-field>
              </v-form>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="#069A8E" dark @click="login()">ตกลง</v-btn>
            </v-card-actions>
          </v-card>
        </template>
      </v-dialog>
    </v-col>
  </v-row>
</template>

<script>
import axios from 'axios'
import 'animate.css'
import Morning_shift from '~/components/Morning_shift.vue'
import Afternoon_shift from '~/components/Afternoon_shift.vue'
import Night_shirt from '~/components/Night_shirt.vue'
import Other_morning from '~/components/Other_morning.vue'
import Other_night from '~/components/Other_night.vue'
import Add_schedule_er from '~/components/Add_schedule_er.vue'
import Add_schedule_department from '~/components/Add_schedule_department.vue'
import moment from 'moment'
import { format, parseISO } from 'date-fns'
export default {
  name: 'IndexPage',
  data() {
    return {
      showdashboard: false,
      menu: false,
      datestart: format(parseISO(new Date().toISOString()), 'yyyy-MM-dd'),
      // opddate_now: new Date().toLocaleDateString('th-TH', {
      //   year: 'numeric',
      //   month: 'long',
      //   day: 'numeric',
      //   weekday: 'long',
      // }),
      dialog_er: false,
      dialog_dp: false,
      departments: '',
      department: '',
      department_select: '',
      depart: true,
      renderComponent: true,
      ershow: true,
      dpshow: true,
      ershow_text: 'ซ่อน',
      dpshow_text: 'ซ่อน',
      dialog_login: false,

      username: '',
      password: '',
      token: '',
      session: '',
      user: 'ผู้ใช้ทั่วไป',
      authenticated: false,
      saved: '',
    }
  },
  computed: {
    computedDateFormattedMomentjs() {
      return this.datestart
        ? moment(this.datestart).locale('th').format('LL')
        : ''
    },
    opddate_now() {
      return this.datestart
        ? moment(this.datestart).locale('th').format('dddd LL')
        : ''
    },
    computedcuser: function () {
      // if (this.session == null) {
      //   this.user = 'ทั่วไป'
      // } else {
      //   this.user = this.session[0].fullname
      // }
      // return this.session
      //   ? (this.session = JSON.parse(localStorage.getItem('token')))
      //   : ''
    },
  },
  components: {
    Morning_shift,
    Afternoon_shift,
    Night_shirt,
    Other_morning,
    Other_night,
    Add_schedule_er,
    Add_schedule_department,
  },
  mounted() {
    this.fecth_department()
    // if (!JSON.parse(localStorage.getItem('token'))) {
    //   this.session = '0'
    // } else {
    //   this.session = JSON.parse(localStorage.getItem('token'))
    // }
  },
  methods: {
    erchange() {
      if (this.ershow == true) {
        this.erbtnshow = false
        this.ershow_text = 'ซ่อน'
      } else if (this.ershow == false) {
        this.erbtnshow = true
        this.ershow_text = 'แสดง'
      }
    },
    dpchange() {
      if (this.dpshow == true) {
        this.dpshow_text = 'ซ่อน'
      } else if (this.dpshow == false) {
        this.dpshow_text = 'แสดง'
      }
    },
    reredereditparent() {
      this.forceRerender()
    },
    forceRerender() {
      // Removing my-component from the DOM
      this.renderComponent = false

      this.$nextTick(() => {
        // Adding the component back in
        this.renderComponent = true
      })
      // this.session = JSON.parse(localStorage.getItem('token'))
      // this.user = this.session[0].fullname
    },
    //er
    open_er_dialog() {
      if (this.session == false) {
        this.$swal({
          title: 'ท่านไม่มีสิทธิเพิ่มหรือแก้ข้อมูล',
          icon: 'warning',
          showCancelButton: true,
          cancelButtonText: 'ยกเลิก',
          confirmButtonColor: '#069A8E',
          cancelButtonColor: '#d33',
          confirmButtonText: 'เข้าสู่ระบบ',
        }).then((result) => {
          if (result.isConfirmed) {
            this.call_login()
          }
        })
      } else {
        if (this.dialog_er == true) {
          this.dialog_er = false
          this.dialog_er = true
        } else {
          this.dialog_er = true
        }
      }
    },
    //ส่งค่า false กลับมา
    close_er_dialog(er) {
      this.dialog_er = er

      this.forceRerender()

      // this.$forceUpdate()
      // this.$nuxt.refresh()
      // setInterval(this.$router.go(), 5000)
    },
    //dp
    open_dp_dialog() {
      if (this.session == false) {
        this.$swal({
          title: 'ท่านไม่มีสิทธิเพิ่มหรือแก้ข้อมูล',
          icon: 'warning',
          showCancelButton: true,
          cancelButtonText: 'ยกเลิก',
          confirmButtonColor: '#069A8E',
          cancelButtonColor: '#d33',
          confirmButtonText: 'เข้าสู่ระบบ',
        }).then((result) => {
          if (result.isConfirmed) {
            this.call_login()
          }
        })
      } else {
        if (this.dialog_dp == true) {
          this.dialog_dp = false
          this.dialog_dp = true
        } else {
          this.dialog_dp = true
        }
      }
    },
    //ส่งค่า false กลับมา
    close_dp_dialog(dp) {
      this.dialog_dp = dp
      this.forceRerender()
    },
    refresh() {
      // this.$forceUpdate()
      this.forceRerender()

      // this.$router.go()
      //this.$nuxt.refresh()
    },
    //ดึง department
    async fecth_department() {
      await axios
        .get(`${this.$axios.defaults.baseURL}department_noer.php`)
        .then((response) => {
          this.departments = response.data
          this.showdashboard = true
        })
    },
    depart_select() {
      // this.department_select = this.department
      // console.log(this.department)

      this.$refs.usedepartin.fecth_schedule_staff(
        this.department,
        this.datestart
      )
      this.$refs.usedepartout.fecth_schedule_staff(
        this.department,
        this.datestart
      )
    },
    date_select() {
      this.$refs.datechange_morning.fecth_schedule_staff(this.datestart)
      this.$refs.datechange_morning.fecth_schedule_resident(this.datestart)
      this.$refs.datechange_morning.fecth_schedule_intern(this.datestart)
      this.$refs.datechange_afternoon.fecth_schedule_staff(this.datestart)
      this.$refs.datechange_afternoon.fecth_schedule_resident(this.datestart)
      this.$refs.datechange_afternoon.fecth_schedule_intern(this.datestart)
      this.$refs.datechange_night.fecth_schedule_staff(this.datest)
      this.$refs.datechange_night.fecth_schedule_resident(this.datestart)
      this.$refs.datechange_night.fecth_schedule_intern(this.datestart)
      // this.$forceUpdate()
      this.forceRerender()
      this.menu = false
    },
    call_login() {
      this.dialog_login = true
    },
    close_login() {
      this.dialog_login = false
    },
    login() {
      axios
        .post(`${this.$axios.defaults.baseURL}login_check.php`, {
          user: this.username,
          pass: this.password,
        })

        .then((response) => {
          this.tokens = response.data
          localStorage.setItem('token', JSON.stringify(this.tokens))
          localStorage.setItem('saved', new Date().getTime())
          this.token = JSON.parse(localStorage.getItem('token'))
          if (this.token[0].state == 'no') {
            this.popuplogin()
            this.clear()
            this.dialog_login = true
            this.authenticated = false
          } else {
            this.dialog_login = false
            this.forceRerender()
            this.session = JSON.parse(localStorage.getItem('token'))
            this.user = this.session[0].fullname
            this.authenticated = true
            // login 2 ชม ถ้าเกินให้ออก แล้ว clear localstorage
            this.hours = 2
            this.saved = localStorage.getItem('saved')
            if (
              this.saved &&
              new Date().getTime() - this.saved > this.hours * 60 * 60 * 1000
            ) {
              localStorage.clear()
              this.$router.push('/')
            }
          }
        })
    },
    popuplogin() {
      this.$swal({
        title: 'แจ้งเตือน',
        text: 'ท่านไม่ได้รับอณุญาติให้เข้าสู่ระบบ',
        icon: 'error',
        confirmButtonText: 'ตกลง',
      })
    },
    popupadd() {
      this.$swal({
        title: 'ท่านไม่มีสิทธิเพิ่มหรือแก้ข้อมูล',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'ยกเลิก',
        confirmButtonColor: '#069A8E',
        cancelButtonColor: '#d33',
        confirmButtonText: 'เข้าสู่ระบบ',
      }).then((result) => {
        if (result.isConfirmed) {
          this.$emit('calllogin', 'calllogin dialog')
        }
      })
    },
    clear() {
      this.username = ''
      this.password = ''
    },

    login_load() {
      if (localStorage.getItem('token')) {
        this.session = JSON.parse(localStorage.getItem('token'))
        if (this.session == null) {
          this.authenticated = false
        } else {
          this.authenticated = true
          this.user = this.session[0].fullname
          this.token = this.session[0].token
        }
      } else {
        // alert('session ว่าง')
      }
    },
    logout() {
      localStorage.removeItem('token')
      localStorage.clear()
      this.forceRerender()
      this.$refs.datechange_morning.logout()
      this.$refs.datechange_afternoon.logout()
      this.$refs.datechange_night.logout()
    },
  },
  beforeMount() {
    this.login_load()
  },
}
</script>
<style>
#app {
  font-family: 'Trirong', serif;
}
.text-green input {
  color: #069a8e !important;
}

.dd {
  magin-top: 0px;
}
</style>
