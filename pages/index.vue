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
            class="white-text pa-2 text-h5 animate__animated animate__headShake"
            outlined
            tile
          >
            {{ opddate_now }}
          </div>
        </v-alert>
      </div>

      <v-card>
        <v-card-title class="headline"> </v-card-title>
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
    </v-col>
  </v-row>
</template>

<script>
import 'animate.css'
import Morning_shift from '~/components/Morning_shift.vue'
import Afternoon_shift from '~/components/Afternoon_shift.vue'
import Night_shirt from '~/components/Night_shirt.vue'
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
    }
  },
  components: {
    Morning_shift,
    Afternoon_shift,
    Night_shirt,
  },
}
</script>
<style>
#app {
  font-family: 'Trirong', serif;
}
</style>
