<template>
  <v-card :loading="loading" class="mx-auto my-12" max-width="374">
    <template slot="progress">
      <v-progress-linear color="deep-purple" indeterminate></v-progress-linear>
    </template>

    <!-- <v-card-title class="text-h4 blue--text">เช้า</v-card-title> -->
    <!-- <v-card-text justify="center" align="center">
      <div class="text-h4 blue--text text-decoration-underline">ดึก</div>
    </v-card-text> -->
  <v-toolbar dark color="#3A3845 " class="white--text text-h6" >
            <v-icon class="icons">
              mdi-weather-night 
            </v-icon>
            <v-toolbar-title>เวรดึก</v-toolbar-title>
  </v-toolbar>
    <!-- <v-card-text>
      <v-row align="center" class="mx-0">
        <div class="grey--text ms-4">4.5 (413)</div>
      </v-row>

      <div class="my-4 text-subtitle-1">$ • Italian, Cafe</div>

      <div>
        Small plates, salads & sandwiches - an intimate setting with 12 indoor
        seats plus patio seating.
      </div>
    </v-card-text> -->

    <v-card-title
      >STAFF
      <v-row align="center" class="mx-0">
        <div class="grey--text ms-4">(ER)</div>
      </v-row>
      <v-spacer />
      <v-icon class="text-h4" color="#FFF56D">mdi-doctor </v-icon></v-card-title
    >

    <v-card-text>
      <div class="text-h6 green--text">นพ ศุภชัย จรัสกร</div>
      <div class="text-h6 green--text">นพ ศุภชัย จรัสกร</div>
    </v-card-text>

    <v-card-text>
      <v-chip-group
        multiple
        v-model="selection"
        active-class="deep-purple accent-4 white--text"
        column
      >
        <v-chip>8:30-12:30</v-chip>

        <v-chip>12:30-16:30</v-chip>

        <!-- <v-chip>16:30-20:30</v-chip>

        <v-chip>20:30-0:30</v-chip> -->
      </v-chip-group>
    </v-card-text>
    <v-divider class="mx-4"></v-divider>

    <v-card-title
      >RESIDENT
      <v-row align="center" class="mx-0">
        <div class="grey--text ms-4">(ER)</div>
      </v-row>
      <v-spacer />
      <v-icon class="text-h4" color="#40DFEF">mdi-doctor </v-icon></v-card-title
    ></v-card-title
    >
    <v-card-text>
      <div class="text-h6 green--text">นพ ศุภชัย จรัสกร</div>
      <div class="text-h6 green--text">นพ ศุภชัย จรัสกร</div>
    </v-card-text>
    <v-card-text>
      <v-chip-group
        
        multiple
        v-model="selection"
        active-class="deep-purple accent-4 white--text"
        column
      >
        <v-chip>8:30-12:30</v-chip>

        <v-chip>12:30-16:30</v-chip>

        <!-- <v-chip>16:30-20:30</v-chip>

        <v-chip>20:30-0:30</v-chip> -->
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
    ></v-card-title
    >
    <v-card-text>
      <div class="text-h6 green--text">นพ ศุภชัย จรัสกร</div>
      <div class="text-h6 green--text">นพ ศุภชัย จรัสกร</div>
    </v-card-text>
    <v-card-text>
      <v-chip-group
        multiple
        v-model="selection"
        active-class="deep-purple accent-4 white--text"
        column
      >
        <v-chip>8:30-12:30</v-chip>

        <v-chip>12:30-16:30</v-chip>

        <!-- <v-chip>16:30-20:30</v-chip>

        <v-chip>20:30-0:30</v-chip> -->
      </v-chip-group>
    </v-card-text>

    <v-card-actions>
      <!-- <v-btn color="deep-purple lighten-2" text @click="reserve">
        Reserve
      </v-btn> -->
    </v-card-actions>
  </v-card>
</template>