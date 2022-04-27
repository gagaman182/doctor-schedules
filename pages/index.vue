<template>
  <v-row justify="center" align="center">
    <v-col cols="12">
      <div class="justify-center mb-6">
        <!-- <v-alert border="left" colored-border color="#7CB342" elevation="2">
          <div
            class="white-text pa-2 text-h4 animate__animated animate__headShake"
            outlined
            tile
          >
            {{ opddate_now }}
          </div>
        </v-alert> -->
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
            class="white-text pa-2 text-h3 animate__animated animate__headShake"
            outlined
            tile
          >
            {{ opddate_now }}
          </div>
        </v-alert>
      </div>

      <v-card>
        <v-card-title class="text-h3 red--text">
          Emergency Room
          <v-spacer />
          <v-icon class="text-h3 mb-2 red--text">mdi-car-emergency </v-icon>
        </v-card-title>
        <v-divider />
        <v-card-title>
          <v-spacer />
          <v-btn
            class="white--text"
            x-large
            color="#069A8E"
            @click="open_er_dialog"
          >
            <v-icon>mdi-calendar-plus </v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12" sm="4"><Morning_shift /></v-col>
            <v-col cols="12" sm="4"><Afternoon_shift /></v-col>
            <v-col cols="12" sm="4"><Night_shirt /></v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <!-- <v-spacer /> -->
        </v-card-actions>
      </v-card>
      <v-card>
        <v-card-title class="text-h3 blue--text">
          Other Departments
          <v-spacer />
          <v-icon class="text-h3 mb-2" color="blue"
            >mdi-hospital-building
          </v-icon>
        </v-card-title>
        <v-divider />
        <v-card-title>
          <v-spacer />
          <v-btn
            class="white--text"
            x-large
            color="#069A8E"
            @click="open_dp_dialog"
          >
            <v-icon>mdi-calendar-plus </v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12" sm="6"><Other_morning /></v-col>
            <v-col cols="12" sm="6"><Other_night /></v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <!-- <v-spacer /> -->
        </v-card-actions>
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
  </v-row>
</template>

<script>
import 'animate.css'
import Morning_shift from '~/components/Morning_shift.vue'
import Afternoon_shift from '~/components/Afternoon_shift.vue'
import Night_shirt from '~/components/Night_shirt.vue'
import Other_morning from '~/components/Other_morning.vue'
import Other_night from '~/components/Other_night.vue'
import Add_schedule_er from '~/components/Add_schedule_er.vue'
import Add_schedule_department from '~/components/Add_schedule_department.vue'
export default {
  name: 'IndexPage',
  data() {
    return {
      opddate_now: new Date().toLocaleDateString('th-TH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        weekday: 'long',
      }),
      dialog_er: false,
      dialog_dp: false,
    }
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
  methods: {
    //er
    open_er_dialog() {
      if (this.dialog_er == true) {
        this.dialog_er = false
        this.dialog_er = true
      } else {
        this.dialog_er = true
      }
    },
    //ส่งค่า false กลับมา
    close_er_dialog(er) {
      this.dialog_er = er
      this.$router.go()
    },
    //dp
    open_dp_dialog() {
      if (this.dialog_dp == true) {
        this.dialog_dp = false
        this.dialog_dp = true
      } else {
        this.dialog_dp = true
      }
    },
    //ส่งค่า false กลับมา
    close_dp_dialog(dp) {
      this.dialog_dp = dp
    },
  },
}
</script>
<style>
#app {
  font-family: 'Trirong', serif;
}
</style>
