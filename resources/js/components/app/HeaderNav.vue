<template>
    <div>
        <nav class="navbar navbar-dark navbar-expand-md navbar-light bg-primary shadow-sm">
            <div class="container-fluid">
                <router-link class="navbar-brand" to="/">National Economy Online</router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <router-link to="/help" class="nav-link">ヘルプ</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/release" class="nav-link">リリースノート</router-link>
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <router-link to="/login" class="nav-link">ログイン</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>
<script>
export default {
}
</script>