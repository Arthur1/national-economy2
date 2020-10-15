<template>
    <div id="app">
        <header v-if="$route.meta.hasHeader"><header-nav /></header>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>
<script>
import HeaderNav from './components/app/HeaderNav.vue'

export default {
    components: {
        HeaderNav
    }
}
</script>
