<template>
  <v-row justify="space-around">
    <v-col cols="auto">
      <v-dialog
        transition="dialog-top-transition"
        max-width="800"
        v-model="dialog_dp"
      >
        <template v-slot:default="dialog_dp">
          <v-card>
            <v-toolbar color="#069A8E" dark class="text-h5"
              >Other Departments
              <v-spacer />
              <v-btn
                class="mx-2"
                fab
                dark
                small
                color="red"
                @click="close_dp_dialog"
              >
                <v-icon dark> mdi-close </v-icon>
              </v-btn>
            </v-toolbar>
            <v-card-text>
              <div class="text-h2 pa-12">DP</div>
            </v-card-text>
            <v-card-actions class="justify-end">
              <v-btn
                x-large
                color="red"
                @click="close_dp_dialog"
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
export default {
  props: ['dialog_dp'],

  methods: {
    close_dp_dialog(event) {
      this.dialog_dp = false
      this.$emit('closedialog_dp', this.dialog_dp)
    },
  },
}
</script>

