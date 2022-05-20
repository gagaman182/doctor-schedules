<template>
  <v-card :loading="loading" class="mx-auto my-12">
    <template slot="progress">
      <v-progress-linear color="deep-purple" indeterminate></v-progress-linear>
    </template>
    <v-toolbar dark color="#40DFEF " class="white--text text-h6">
      <v-icon class="icons"> mdi-weather-sunset-up </v-icon>
      <v-toolbar-title>เวรเช้า</v-toolbar-title>
      <v-spacer />
      {{ showdate_day }}
    </v-toolbar>
    <div>
      <v-card-title
        >STAFF
        <v-row align="center" class="mx-0">
          <div class="grey--text ms-4">(ER)</div>
        </v-row>
        <v-spacer />
        <v-icon class="text-h4" color="#FFF56D"
          >mdi-doctor
        </v-icon></v-card-title
      >

      <v-card-text
        v-if="display_staff"
        v-for="sc in schedule_staff"
        :key="sc.uhid"
      >
        <div
          id="name"
          class="text-h6 blue--text"
          @click="edit_schedule(sc.uhid)"
        >
          {{ sc.doctor_name }}
        </div>
        <!-- <div class="text-h6 green--text">ไม่พบข้อมูล</div> -->

        <v-chip-group v-model="sc.time4" column color="#069A8E" multiple>
          <v-chip filter outlined class="not-active"
            ><v-icon left> mdi-alarm-check </v-icon> 8:30-12:30
          </v-chip>
          <v-chip filter outlined class="not-active"
            ><v-icon left> mdi-alarm-check </v-icon> 12:30-16:30
          </v-chip>
          <!-- <v-chip filter outlined
            ><v-icon left> mdi-alarm-check </v-icon> 16:30-20:30
          </v-chip>
          <v-chip filter outlined
            ><v-icon left> mdi-alarm-check </v-icon>20:30-0:30</v-chip
          >
          <v-chip filter outlined
            ><v-icon left> mdi-alarm-check </v-icon>0:30-8:30</v-chip
          > -->
        </v-chip-group>
      </v-card-text>

      <v-divider class="mx-4"></v-divider>
    </div>

    <v-card-title
      >RESIDENT
      <v-row align="center" class="mx-0">
        <div class="grey--text ms-4">(ER)</div>
      </v-row>
      <v-spacer />
      <v-icon class="text-h4" color="#40DFEF">mdi-doctor </v-icon></v-card-title
    >
    <v-card-text
      v-if="display_resident"
      v-for="sc in schedule_resident"
      :key="sc.uhid"
    >
      <div id="name" class="text-h6 blue--text" @click="edit_schedule(sc.uhid)">
        {{ sc.doctor_name }}
      </div>

      <v-chip-group v-model="sc.time4" column color="#069A8E" multiple>
        <v-chip filter outlined class="not-active"
          ><v-icon left> mdi-alarm-check </v-icon> 8:30-12:30
        </v-chip>
        <v-chip filter outlined class="not-active"
          ><v-icon left> mdi-alarm-check </v-icon> 12:30-16:30
        </v-chip>
      </v-chip-group>
    </v-card-text>
    <v-divider class="mx-4"></v-divider>
    <v-card-title
      >INTERN
      <v-row align="center" class="mx-0">
        <div class="grey--text ms-4">(ER)</div>
      </v-row>
      <v-spacer />
      <v-icon class="text-h4" color="#9FB4FF">mdi-doctor </v-icon></v-card-title
    >
    <v-card-text
      v-if="display_intern"
      v-for="sc in schedule_intern"
      :key="sc.uhid"
    >
      <div id="name" class="text-h6 blue--text" @click="edit_schedule(sc.uhid)">
        {{ sc.doctor_name }}
      </div>
      <!-- <v-list-item-title class=" blue--text">{{ sc.doctor_name }}</v-list-item-title> -->

      <v-chip-group v-model="sc.time4" column color="#069A8E" multiple>
        <v-chip filter outlined class="not-active"
          ><v-icon left> mdi-alarm-check </v-icon> 8:30-12:30
        </v-chip>
        <v-chip filter outlined class="not-active"
          ><v-icon left> mdi-alarm-check </v-icon> 12:30-16:30
        </v-chip>
      </v-chip-group>
    </v-card-text>
    <v-card-text>
      <Edit_schedule_er
        v-if="dialog_er"
        :dialog_er="dialog_er"
        :uhid_edit="uhid"
        :schedule_staff_id="schedule_staff_id"
        @closedialog_er="close_er_dialog"
        @rerender="rerederedit"
    /></v-card-text>
  </v-card>
</template>
<script>
import axios from 'axios'
import Edit_schedule_er from '~/components/Edit_schedule_er.vue'
import moment from 'moment'
import { format, parseISO } from 'date-fns'
export default {
  props: ['datestart'],
  data() {
    return {
      schedule_staff: '',
      schedule_resident: '',
      schedule_intern: '',
      display_staff: false,
      display_resident: false,
      display_intern: false,
      dialog_er: false,
      uhid: '',
      schedule_staff_id: '',

      datestart_change: '',
      renderComponent: true,
      showdate: '',
    }
  },
  computed: {
    showdate_day() {
      return this.showdate
        ? moment(this.showdate).locale('th').format('LL')
        : ''
    },
  },
  components: {
    Edit_schedule_er,
  },
  mounted() {
    this.fecth_schedule_staff()
    this.fecth_schedule_resident()
    this.fecth_schedule_intern()
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

    async fecth_schedule_staff(datechange) {
      if (!datechange) {
        this.datestart_change = this.datestart
        this.showdate = this.datestart
      } else {
        this.datestart_change = datechange
        this.showdate = datechange
      }

      await axios

        // .get(
        //   `${this.$axios.defaults.baseURL}staff/schedules_select_staff_morning.php`
        // )
        .post(
          `${this.$axios.defaults.baseURL}staff/schedules_select_staff_morning.php`,
          {
            datastart: this.datestart_change,
          }
        )
        .then((response) => {
          this.schedule_staff = response.data

          if (this.schedule_staff.length > 0) {
            this.display_staff = true
          } else {
            this.display_staff = false
          }
        })
    },
    async fecth_schedule_resident(datechange) {
      if (!datechange) {
        this.datestart_change = this.datestart
        this.showdate = this.datestart
      } else {
        this.datestart_change = datechange
        this.showdate = datechange
      }
      await axios
        // .get(
        //   `${this.$axios.defaults.baseURL}resident/schedules_select_resident_morning.php`
        // )
        .post(
          `${this.$axios.defaults.baseURL}resident/schedules_select_resident_morning.php`,
          {
            datastart: this.datestart_change,
          }
        )
        .then((response) => {
          this.schedule_resident = response.data
          if (this.schedule_resident.length > 0) {
            this.display_resident = true
          } else {
            this.display_resident = false
          }
        })
    },
    async fecth_schedule_intern(datechange) {
      if (!datechange) {
        this.datestart_change = this.datestart
        this.showdate = this.datestart
      } else {
        this.datestart_change = datechange
        this.showdate = datechange
      }
      await axios
        // .get(
        //   `${this.$axios.defaults.baseURL}intern/schedules_select_intern_morning.php`
        // )
        .post(
          `${this.$axios.defaults.baseURL}intern/schedules_select_intern_morning.php`,
          {
            datastart: this.datestart_change,
          }
        )
        .then((response) => {
          this.schedule_intern = response.data
          if (this.schedule_intern.length > 0) {
            this.display_intern = true
          } else {
            this.display_intern = false
          }
        })
    },
    async edit_schedule(uhid) {
      this.uhid = uhid

      await axios
        .post(`${this.$axios.defaults.baseURL}schedules_select_id.php`, {
          uhid: this.uhid,
        })
        .then((response) => {
          this.schedule_staff_id = response.data
          if (this.dialog_er == true) {
            this.dialog_er = false
            this.dialog_er = true
          } else {
            this.dialog_er = true
          }
        })
      // this.fecth_schedule_staff_id(uhid)
    },
    //ส่งค่า false กลับมา
    close_er_dialog(er) {
      this.dialog_er = er
    },
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
