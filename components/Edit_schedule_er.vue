<template>
  <v-row justify="space-around">
    <v-col cols="auto">
      <v-dialog
        transition="dialog-top-transition"
        max-width="800"
        v-model="dialog_er"
      >
        <template v-slot:default="dialog_er">
          <v-card>
            <v-toolbar color="#069A8E" dark class="text-h5">
              Emergency Room
              <v-spacer />
              <v-btn
                class="mx-2"
                fab
                dark
                small
                color="red"
                @click="close_er_dialog"
              >
                <v-icon dark> mdi-close </v-icon>
              </v-btn></v-toolbar
            >

            <v-card-text>
              <!-- <div class="text-h5 pa-12 mx-2">ER</div> -->

              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-title class="text-h5 grey--text">
                    เพิ่มข้อมูลตารางเวรประจำวัน
                  </v-list-item-title>
                  <v-list-item-subtitle>อุบัติเหตุฉุกเฉิน</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>

              <v-row>
                <v-col>
                  <v-menu
                    ref="menu"
                    v-model="menu"
                    :close-on-content-click="false"
                    :return-value.sync="date"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="datestart"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        label="วันที่"
                        filled
                        rounded
                        outlined
                        dense
                        color="#069A8E"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="datestart"
                      scrollable
                      locale="th-TH"
                      color="#069A8E"
                    >
                      <v-spacer></v-spacer>
                      <v-btn text color="#069A8E" @click="menu = false">
                        ยกเลิก
                      </v-btn>
                      <v-btn
                        text
                        color="#069A8E"
                        @click="$refs.menu.save(datestart)"
                      >
                        ตกลง
                      </v-btn>
                    </v-date-picker>
                  </v-menu>
                </v-col>
                <v-col cols="12" ml-100>
                  <v-text-field
                    label="แผนก"
                    prepend-icon="mdi-office-building"
                    filled
                    rounded
                    dense
                    readonly
                    outlined
                    v-model="er"
                    color="#069A8E"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-autocomplete
                    prepend-icon="mdi-doctor"
                    :items="doctors"
                    v-model="doctor"
                    item-text="name"
                    item-value="doc_code"
                    label="แพทย์"
                    dense
                    filled
                    rounded
                    outlined
                    color="#069A8E"
                  ></v-autocomplete>
                  <v-divider />
                </v-col>

                <v-col cols="12" sm="7">
                  <h2 class="text-h6 mb-2">แพทย์เวร</h2>
                  <v-chip-group v-model="doctor_level" column color="#069A8E">
                    <v-chip filter outlined
                      ><v-icon left> mdi-doctor </v-icon> STAFF
                    </v-chip>
                    <v-chip filter outlined
                      ><v-icon left> mdi-doctor </v-icon> RESIDENT
                    </v-chip>
                    <v-chip filter outlined
                      ><v-icon left> mdi-doctor </v-icon> INTERN
                    </v-chip>
                  </v-chip-group>
                </v-col>
                <v-col cols="12" sm="5">
                  <h2 class="text-h6 mb-2">เข้าเวร</h2>
                  <v-chip-group v-model="shift" column color="#069A8E">
                    <v-chip filter outlined @input="shift_add()">
                      <v-icon left> mdi-weather-sunset-up </v-icon>
                      เช้า
                    </v-chip>
                    <v-chip filter outlined @input="shift_add()"
                      ><v-icon left> mdi-weather-sunset-down </v-icon> บ่าย
                    </v-chip>
                    <v-chip filter outlined @input="shift_add()"
                      ><v-icon left> mdi-weather-night </v-icon> ดึก
                    </v-chip>
                  </v-chip-group>
                </v-col>
                <v-col cols="12">
                  <v-divider />
                  <h2 class="text-h6 mb-2">ช่วงเวลา</h2>
                  <v-chip-group v-model="time" column color="#069A8E" multiple>
                    <v-chip filter outlined
                      ><v-icon left> mdi-alarm-check </v-icon> 8:30-12:30
                    </v-chip>
                    <v-chip filter outlined
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
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions class="justify-end">
              <v-btn
                x-large
                color="#069A8E"
                @click="edit_schedule"
                class="white--text text-h6"
                >แก้ไข</v-btn
              >
              <v-btn
                x-large
                color="#F8B400"
                @click="delete_schedule"
                class="white--text text-h6"
                >ลบ</v-btn
              >

              <v-btn
                x-large
                color="red"
                @click="close_er_dialog"
                class="white--text text-h6"
                >ปิด</v-btn
              >
            </v-card-actions>
          </v-card>
        </template>
      </v-dialog>
    </v-col>
  </v-row>
</template>
<script>
import axios from 'axios'

export default {
  props: ['dialog_er', 'uhid_edit', 'schedule_staff_id'],
  data() {
    return {
      uhid: '',
      datestart: '',
      er: 'ER',
      doctors: '',
      doctor: '',
      doctor_name: '',
      doctor_level: '',
      shift: '',
      time: '',
      message: '',
    }
  },
  mounted() {
    this.fecth_doctor()
    this.uhid = this.schedule_staff_id[0].uhid
    this.datestart = this.schedule_staff_id[0].datestart
    this.doctor = this.schedule_staff_id[0].doctor
    this.doctor_name = this.schedule_staff_id[0].doctor_name
    this.doctor_level = this.schedule_staff_id[0].doctor_level
    this.shift = this.schedule_staff_id[0].shift
    this.time = this.schedule_staff_id[0].time4
  },

  methods: {
    close_er_dialog(event) {
      this.dialog_er = false
      this.$emit('closedialog_er', this.dialog_er)
    },
    // ดึง doctor
    async fecth_doctor() {
      await axios
        .get(`${this.$axios.defaults.baseURL}doctor.php`)
        .then((response) => {
          this.doctors = response.data
        })
    },
    //เลือกเวลา
    shift_add() {
      if (this.shift == '0') {
        this.time = [0, 1]
      } else if (this.shift == '1') {
        this.time = [2, 3]
      } else if (this.shift == '2') {
        this.time = [4]
      } else {
        this.time = ''
      }
    },
    edit_schedule() {
      //alert(this.uhid)
      // alert(this.datestart)
      // alert(this.er)
      // alert(this.doctor)
      // alert(this.doctor_level)
      // alert(this.shift)
      // alert(this.time)
      if (!this.uhid) {
        this.$swal({
          title: 'แจ้งเตือน',
          text: 'ไม่พบลำดับการแก้ไขข้อมูล',
          icon: 'error',
          confirmButtonText: 'ตกลง',
        })
      } else {
        axios
          .put(`${this.$axios.defaults.baseURL}schedules_update.php`, {
            uhid: this.uhid,
            datestart: this.datestart,
            er: this.er,
            doctor: this.doctor,
            doctor_level: this.doctor_level,
            shift: this.shift,
            time: this.time.toString(),
          })
          .then((response) => {
            this.message = response.data
            if (this.message[0].message === 'แก้ไขข้อมูลสำเร็จ') {
              this.$swal({
                title: 'สถานะการแก้ไข',
                text: this.message[0].message,
                icon: 'success',
                confirmButtonText: 'ตกลง',
              })
              this.clear_form()
              this.close_er_dialog()
            } else {
              this.$swal({
                title: 'สถานะการเพิ่ม',
                text: this.message[0].message,
                icon: 'error',
                confirmButtonText: 'ตกลง',
              })
            }
          })
      }
    },

    clear_form() {
      this.uhid = ''
      this.datestart = ''
      this.er = ''
      this.doctor = ''
      this.doctor_level = ''
      this.shift = ''
      this.time = ''
      //refesh after add data
      setInterval(this.$router.go(), 5000)
    },
    //ลบ ข่อมูล
    delete_schedule() {
      //if (!this.epidem_report_quid) {
      if (!this.uhid) {
        this.$swal({
          title: 'แจ้งเตือน',
          text: 'ไม่พบลำดับการลบข้อมูล',
          icon: 'error',
          confirmButtonText: 'ตกลง',
        })
      } else {
        this.$swal({
          title: 'คุณแน่ใจว่าต้องการลบข้อมูลนี้?',
          text: 'แพทย์ ' + this.doctor_name + ' เวรวันที่ ' + this.datestart,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#51adcf',
          cancelButtonColor: '#686d76',
          confirmButtonText: 'ลบ',
          cancelButtonText: 'ยกเลิก',
        }).then((result) => {
          if (result.isConfirmed) {
            axios
              .put(`${this.$axios.defaults.baseURL}schedules_delete.php`, {
                uhid: this.uhid,
              })
              .then((response) => {
                this.message = response.data

                if (this.message[0].message === 'ลบข้อมูลสำเร็จ') {
                  this.$swal({
                    title: 'สถานะการลบ',
                    text: this.message[0].message,
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                  })
                  this.close_er_dialog()
                  this.clear_form()
                } else {
                  this.$swal({
                    title: 'สถานะการลบ',
                    text: this.message[0].message,
                    icon: 'error',
                    confirmButtonText: 'ตกลง',
                  })
                }
              })
          }
        })
      }
    },
  },
}
</script>

