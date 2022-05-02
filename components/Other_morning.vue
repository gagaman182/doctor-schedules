<template>
  <v-card :loading="loading" class="mx-auto my-12">
    <template slot="progress">
      <v-progress-linear color="deep-purple" indeterminate></v-progress-linear>
    </template>

    <!-- <v-card-title class="text-h4 blue--text">เช้า</v-card-title> -->
    <!-- <v-card-text justify="center" align="center">
      <div class="text-h4 blue--text text-decoration-underline">ดึก</div>
    </v-card-text> -->
    <v-toolbar dark color="#396EB0 " class="white--text text-h6">
      <v-icon class="icons"> mdi-weather-sunset-up </v-icon>
      <v-toolbar-title>ในเวลา</v-toolbar-title>
    </v-toolbar>
    <div v-for="sc in schedule_intime" :key="sc.uhid">
      <v-card-title
        >{{ sc.department }}
        <v-row align="center" class="mx-0">
          <div class="grey--text ms-4">Department</div>
        </v-row>
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
  </v-card>
</template>
<script>
import axios from 'axios'
import Edit_schedule_er from '~/components/Edit_schedule_er.vue'

export default {
  data() {
    return {
      schedule_intime: '',
      display: false,
      dialog_er: false,
      uhid: '',
      schedule_staff_id: '',
    }
  },
  components: {
    Edit_schedule_er,
  },
  mounted() {
    this.fecth_schedule_staff()
  },
  methods: {
    // ดึง schedule
    async fecth_schedule_staff() {
      await axios
        .get(
          `${this.$axios.defaults.baseURL}intime/schedules_select_intime.php`
        )
        .then((response) => {
          this.schedule_intime = response.data

          if (this.schedule_staff.length > 0) {
            this.display = true
          } else {
            this.display = false
          }
        })
    },

    edit_schedule(uhid) {
      this.uhid = uhid
      alert(this.uhid)
      // await axios
      //   .post(`${this.$axios.defaults.baseURL}schedules_select_id.php`, {
      //     uhid: this.uhid,
      //   })
      //   .then((response) => {
      //     this.schedule_staff_id = response.data
      //     if (this.dialog_er == true) {
      //       this.dialog_er = false
      //       this.dialog_er = true
      //     } else {
      //       this.dialog_er = true
      //     }
      //   })
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