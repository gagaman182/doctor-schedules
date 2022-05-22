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
        <v-card-title class="text-h4 red--text">
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
                ></v-text-field>
                <!-- @click:clear="datestart = null" -->
                <!-- clearable ปุ่ม กากบาท -->
              </template>
              <v-date-picker
                locale="th-TH"
                v-model="datestart"
                @change="date_select()"
              >
                <!-- @change="menu = false" กรณีไม่ใช้ปุ่มกด ใส่ใน v-date-picker -->
                <v-spacer></v-spacer>

                <!-- <v-btn text color="#069A8E" @click="menu = false"> ตกลง </v-btn> -->
              </v-date-picker>
            </v-menu>
          </div>
          <div class="pr-2">
            <v-btn class="white--text" x-large color="#F8B400" @click="refresh">
              <v-icon>mdi-refresh-circle </v-icon>
            </v-btn>
          </div>
          <v-btn
            class="white--text"
            x-large
            color="#069A8E"
            @click="open_er_dialog"
          >
            <v-icon>mdi-calendar-plus </v-icon>
          </v-btn>
        </v-card-title>
        <!-- <v-divider /> -->

        <v-card-text v-show="ershow">
          <v-row>
            <v-col cols="12" sm="4" v-if="showdashboard">
              <Morning_shift
                :datestart="datestart"
                ref="datechange_morning"
                v-if="renderComponent"
                @rerenderparent="reredereditparent"
            /></v-col>
            <v-col cols="12" sm="4" v-else>
              <v-skeleton-loader
                class="mx-auto"
                max-width="300"
                type="card"
              ></v-skeleton-loader>
            </v-col>
            <v-col cols="12" sm="4" v-if="showdashboard">
              <Afternoon_shift
                :datestart="datestart"
                ref="datechange_afternoon"
                v-if="renderComponent"
                @rerenderparent="reredereditparent"
              />
            </v-col>
            <v-col cols="12" sm="4" v-else>
              <v-skeleton-loader
                class="mx-auto"
                max-width="300"
                type="card"
              ></v-skeleton-loader>
            </v-col>
            <v-col cols="12" sm="4" v-if="showdashboard">
              <Night_shirt
                :datestart="datestart"
                ref="datechange_night"
                v-if="renderComponent"
                @rerenderparent="reredereditparent"
            /></v-col>
            <v-col cols="12" sm="4" v-else>
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
        <v-card-title class="text-h4 blue--text">
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
            <v-btn class="white--text" x-large color="#F8B400" @click="refresh">
              <v-icon>mdi-refresh-circle </v-icon>
            </v-btn>
          </div>

          <v-btn
            class="white--text"
            x-large
            color="#069A8E"
            @click="open_dp_dialog"
          >
            <v-icon>mdi-calendar-plus </v-icon>
          </v-btn>
        </v-card-title>
        <!-- <v-divider /> -->

        <v-card-text v-show="dpshow">
          <v-row>
            <v-col cols="12" sm="12">
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
            <v-col cols="12" sm="6" v-if="showdashboard"
              ><Other_morning
                :datestart="datestart"
                ref="usedepartin"
                v-if="renderComponent"
                @rerenderparent="reredereditparent"
            /></v-col>
            <v-col cols="12" sm="6" v-else>
              <v-skeleton-loader
                class="mx-auto"
                max-width="300"
                type="card"
              ></v-skeleton-loader>
            </v-col>
            <v-col cols="12" sm="6" v-if="showdashboard"
              ><Other_night
                :datestart="datestart"
                ref="usedepartout"
                v-if="renderComponent"
                @rerenderparent="reredereditparent"
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
  },
  methods: {
    erchange() {
      if (this.ershow == true) {
        this.ershow_text = 'ซ่อน'
      } else if (this.ershow == false) {
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
    },
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

      // this.forceRerender()

      // this.$forceUpdate()
      // this.$nuxt.refresh()
      // setInterval(this.$router.go(), 5000)
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
      // this.forceRerender()
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
  },
}
</script>
<style>
#app {
  font-family: 'Trirong', serif;
}
</style>
