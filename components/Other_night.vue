<template>
  <v-card>
    <!-- <v-card :loading="loading" class="mx-auto my-12"> -->
    <!-- <template slot="progress">
      <v-progress-linear color="deep-purple" indeterminate></v-progress-linear>
    </template> -->

    <!-- <v-card-title class="text-h4 blue--text">เช้า</v-card-title> -->
    <!-- <v-card-text justify="center" align="center">
      <div class="text-h4 blue--text text-decoration-underline">ดึก</div>
    </v-card-text> -->
    <v-toolbar dark color="#2E4C6D " class="white--text text-h6">
      <v-icon class="icons"> mdi-weather-sunset-down </v-icon>
      <v-toolbar-title>นอกเวลา</v-toolbar-title>
      <v-spacer />
      {{ showdate_day }}
      <v-icon class="icons"> mdi-minus </v-icon>{{ showdate_day_1 }}
    </v-toolbar>

    <div v-if="display" v-for="sc in schedule_outtime" :key="sc.uhid">
      <v-card-title
        >{{ sc.department }}
        <!-- <v-row align="center" class="mx-0">
          <div class="grey--text ms-4">Department</div>
        </v-row> -->
        <v-spacer />
        <v-icon class="text-h4" color="#FF6FB5"
          >mdi-doctor
        </v-icon></v-card-title
      >

      <v-card-title>
        <div
          id="name"
          class="text-h6 green--text"
          @click="edit_schedule(sc.uhid)"
        >
          {{ sc.doctor_name }}
        </div>
        <v-spacer />
        <div
          id="name"
          class="text-h6 blue--text"
          @click="edit_schedule(sc.uhid)"
        >
          {{ sc.doctor_level_name }}
        </div>
      </v-card-title>
      <v-card-text>
        <v-chip-group v-model="sc.time4" column color="#86C6F4" multiple>
          <v-chip filter outlined class="not-active" v-show="hidetime"
            ><v-icon left> mdi-alarm-check </v-icon> 8:30-12:30
          </v-chip>
          <v-chip filter outlined class="not-active" v-show="hidetime"
            ><v-icon left> mdi-alarm-check </v-icon> 12:30-16:30
          </v-chip>
          <v-chip filter outlined
            ><v-icon left> mdi-alarm-check </v-icon> 16:30-20:30
          </v-chip>
          <v-chip filter outlined
            ><v-icon left> mdi-alarm-check </v-icon>20:30-0:30</v-chip
          >
          <v-chip filter outlined
            ><v-icon left> mdi-alarm-check </v-icon>0:30-8:30</v-chip
          >
        </v-chip-group>
      </v-card-text>
    </div>

    <div>
      <Edit_schedule_department
        v-if="dialog_dp"
        :dialog_dp="dialog_dp"
        :uhid_edit="uhid"
        :schedule_staff_id="schedule_staff_id"
        @closedialog_dp="close_dp_dialog"
        @rerender="rerederedit"
      />
    </div>
  </v-card>
</template>
<script>
import axios from 'axios'
import Edit_schedule_department from '~/components/Edit_schedule_department.vue'
import moment from 'moment'
import { format, parseISO } from 'date-fns'
export default {
  props: ['datestart', 'session', 'authenticated'],
  data() {
    return {
      schedule_outtime: '',
      display: false,
      dialog_dp: false,
      hidetime: false,
      uhid: '',
      schedule_staff_id: '',
      department_all: 'all',
      department_use: '',
      departments: '',

      datestart_change: '',
      renderComponent: true,
      showdate: '',
      token: '',
      user: '',
    }
  },
  computed: {
    showdate_day() {
      return this.showdate
        ? moment(this.showdate).locale('th').format('Do')
        : ''
    },
    showdate_day_1() {
      return this.showdate
        ? moment(this.showdate).add(1, 'd').locale('th').format('LL')
        : ''
    },
  },
  components: {
    Edit_schedule_department,
  },
  mounted() {
    this.fecth_schedule_staff()
    this.fecth_department()
  },
  methods: {
    rerederedit() {
      this.$emit('rerenderparent', 'rerender data parent')
    },
    forceRerender() {
      // this.$parent.forceRerender()
      // // Removing my-component from the DOM
      // this.renderComponent = false
      // this.$nextTick(() => {
      //   // Adding the component back in
      //   this.renderComponent = true
      // })
    },
    // ดึง schedule
    async fecth_schedule_staff(depeartment_select, datechange) {
      // console.log(depeartment_select)
      if (!depeartment_select) {
        this.department_use = this.department_all
      } else {
        this.department_use = depeartment_select
      }
      if (!datechange) {
        this.datestart_change = this.datestart
        this.showdate = this.datestart
      } else {
        this.datestart_change = datechange
        this.showdate = datechange
      }
      await axios
        // .get(
        //   `${this.$axios.defaults.baseURL}intime/schedules_select_outtime.php`
        // )
        .post(
          `${this.$axios.defaults.baseURL}intime/schedules_select_outtime.php`,
          {
            department: this.department_use,
            datastart: this.datestart_change,
          }
        )
        .then((response) => {
          this.schedule_outtime = response.data

          if (this.schedule_outtime.length > 0) {
            this.display = true
          } else {
            this.display = false
          }
        })
    },
    async edit_schedule(uhid) {
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
            this.$emit('calllogin', 'calllogin dialog')
          }
        })
      } else {
        this.uhid = uhid
        // alert(this.uhid)
        await axios
          .post(`${this.$axios.defaults.baseURL}schedules_select_id.php`, {
            uhid: this.uhid,
          })
          .then((response) => {
            this.schedule_staff_id = response.data
            if (this.dialog_dp == true) {
              this.dialog_dp = false
              this.dialog_dp = true
            } else {
              this.dialog_dp = true
            }
          })
      }
    },
    //ส่งค่า false กลับมา
    close_dp_dialog(dp) {
      this.dialog_dp = dp
    },
    //ดึง department
    async fecth_department() {
      await axios
        .get(`${this.$axios.defaults.baseURL}department.php`)
        .then((response) => {
          this.departments = response.data
        })
    },
    login_load() {
      if (localStorage.getItem('token')) {
        this.session = JSON.parse(localStorage.getItem('token'))
        if (this.session == null) {
        } else {
          this.user = this.session[0].fullname
          this.token = this.session[0].token
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
      } else {
      }
    },

    logout() {
      location.reload()
    },
  },
  beforeMount() {
    this.login_load()
  },
}
</script>
<style>
#name {
  cursor: pointer;
}
.not-active {
  pointer-events: none;
  cursor: default;
}
</style>