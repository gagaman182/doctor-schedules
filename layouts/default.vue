<template>
  <v-app dark>
    <!-- <v-navigation-drawer
      v-model="drawer"
      :mini-variant="miniVariant"
      :clipped="clipped"
      fixed
      app
    >
      <v-list>
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          :to="item.to"
          router
          exact
        >
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="item.title" />
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer> -->

    <v-app-bar
      :clipped-left="clipped"
      fixed
      app
      src="https://images.pexels.com/photos/1037993/pexels-photo-1037993.jpeg"
    >
      <!-- <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-btn icon @click.stop="miniVariant = !miniVariant">
        <v-icon>mdi-{{ `chevron-${miniVariant ? 'right' : 'left'}` }}</v-icon>
      </v-btn> -->
      <!-- <v-btn icon @click.stop="clipped = !clipped">
        <v-icon>mdi-application</v-icon>
      </v-btn> -->
      <!-- <v-btn icon @click.stop="fixed = !fixed">
        <v-icon>mdi-minus</v-icon>
      </v-btn> -->
      <!-- <v-toolbar-title v-text="title" /> -->
      <img src="@/assets/65.gif" />
      <!-- <v-spacer /> -->
      <h1 class="animate__animated animate__headShake white--text" dark>
        ตารางเวรแพทย์โรงพยาบาลหาดใหญ่
      </h1>
      <!-- <v-list-item-title class="text-h2">
        ตารางเวรแพทย์โรงพยาบาลหาดใหญ่
      </v-list-item-title> -->

      <v-spacer />
      <!-- <v-btn icon @click.stop="rightDrawer = !rightDrawer">
        <v-icon>mdi-menu</v-icon>
      </v-btn> -->
      <v-spacer />
      <!-- <v-btn icon @click.stop="rightDrawer = !rightDrawer">
        <v-icon>mdi-menu</v-icon>
      </v-btn> -->

      <!-- <div class="text-center">
        <v-menu open-on-hover top offset-y>
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="#FFAFAF" dark v-bind="attrs" v-on="on">
              <v-icon>mdi-menu</v-icon>
            </v-btn>
          </template>
          <v-list-item-group v-model="selectedItem">
            <v-list color="#FFAFAF">
              <v-list-item class="white--text">
                <v-list-item-title @click="login">
                  เข้าสู่ระบบ
                </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-list-item-group>
        </v-menu>
      </div> -->
    </v-app-bar>

    <v-main>
      <!-- <v-container>
        <Nuxt />
      </v-container> -->
      <Nuxt />
    </v-main>
    <v-navigation-drawer v-model="rightDrawer" :right="right" temporary fixed>
      <v-list>
        <v-list-item @click.native="right = !right">
          <v-list-item-action>
            <v-icon light> mdi-repeat </v-icon>
          </v-list-item-action>
          <v-list-item-title>Switch drawer (click me)</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-footer :absolute="!fixed" app>
      <span>&copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
  </v-app>
</template>

<script>
import 'animate.css'
export default {
  name: 'DefaultLayout',
  data() {
    return {
      clipped: true,
      drawer: true,
      fixed: true,
      items: [
        {
          icon: 'mdi-apps',
          title: 'Welcome',
          to: '/',
        },
        // {
        //   icon: 'mdi-chart-bubble',
        //   title: 'Inspire',
        //   to: '/inspire',
        // },
      ],
      miniVariant: false,
      right: true,
      rightDrawer: false,
      title: 'ตารางเวรแพทย์',
      dialog: false,
      itemmenu: [{ title: 'ออกจากระบบ' }, { title: 'เข้าสู่ระบบ' }],
      // dialog_login: false,
      user: '',
    }
  },
  methods: {
    add_schedule() {
      this.dialog = true
    },
    // login() {
    //   this.dialog_login = true
    // },
  },
  // beforeMount() {
  //   this.login()
  // },
}
</script>
</script>
<style>
/* google font */
#app {
  font-family: 'Trirong', serif;
}
img {
  width: 4%;
  height: auto;
  display: block;
  margin-right: 15px;
}
h1 {
  font-size: 32px;
  background: -webkit-linear-gradient(#5584ac, #95d1cc);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
</style>
