<template>
    <div class="container">
        <h1 class="text-primary mt-5">リリースノート</h1>
        <h2 class="text-secondary mt-4">2.0.2 <small class="date">2020/10/28</small></h2>
        <p>
            以下の問題を修正しました。
        </p>
        <ul>
            <li>ゲームカフェの$10得る効果が、労働者残り2人のときに発動する</li>
        </ul>
        <h2 class="text-secondary mt-4">2.0.1 <small class="date">2020/10/25</small></h2>
        <p>
            以下の問題を修正しました。
        </p>
        <ul>
            <li>ユーザ登録画面およびゲーム画面にて、ボタンを連打すると二重送信が発生する</li>
        </ul>
        <h2 class="text-secondary mt-4">2.0 <small class="date">2020/10/24</small></h2>
        <p>
            ドメインをneo.buratsuki.pageに変更しました。過去バージョンと互換性のない変更を行ったため、データをすべて削除しました。<span class="text-danger">再度ユーザ登録が必要です。</span>
        </p>
        <p>
            以下の新機能を追加しました。
        </p>
        <ul>
            <li>プレイ中のゲームの削除</li>
            <li>ゲーム作成時に、番手を手動で決めるオプションを追加</li>
            <li>ゲームログの閲覧</li>
            <li>デッキリシャッフル、醸造所の起動に関するログを追加</li>
            <li>サマリーの閲覧</li>
            <li>建物売却時の不足金額の表示</li>
            <li>ロールバック時の確認モーダルの廃止</li>
            <li>リロードボタンの廃止</li>
            <li>IPv6でのアクセスに対応</li>
        </ul>
        <p>
            また、以下の問題を修正しました。
        </p>
        <ul>
            <li>特定の条件下で、ゲーム画面の自動更新が行われない</li>
            <li>設計事務所のドロー中にリシャッフルが入ったとき、ドローがやり直される</li>
            <li>売却された建物が自然な並び順でない</li>
        </ul>
        <p>
            以下は既知の問題点です。修正を予定しています
        </p>
        <ul>
            <li>設計事務所のドロー中にリシャッフルが入ったとき、ログの順序関係が局所的に入れ替わってしまう</li>
        </ul>
        <h2 class="text-secondary mt-4">1.1.2 <small class="date">2020/06/30</small></h2>
        <p>
            バージョン1.1の実装に不具合があったため、修正しました。
        </p>
        <h2 class="text-secondary mt-4">1.1.1 <small class="date">2020/05/03</small></h2>
        <p>
            バージョン1.1の実装に不具合があったため、修正しました。
        </p>
        <h2 class="text-secondary mt-4">1.1 <small class="date">2020/05/02</small></h2>
        <p>
            建物売却時に、全て売っても足りない場合だけでなく、売却可能な組み合わせが1通りである場合にも自動で売却されるようになりました。
        </p>
        <p>
            また、以下の問題を修正しました。
        </p>
        <ul>
            <li>売る必要のない建物が自動的に売却されてしまうことがある</li>
            <li>転送装置の使用をキャンセルしたときに労働者が1人しか戻らない</li>
        </ul>
        <h2 class="text-secondary mt-4">1.0.2 <small class="date">2020/04/24</small></h2>
        <p>
            ページ表示の高速化を行いました。
        </p>
        <h2 class="text-secondary mt-4">1.0.1 <small class="date">2020/04/22</small></h2>
        <p>
            以下の問題を修正しました。
        </p>
        <ul>
            <li>ゼネコン使用時のエラーメッセージが正しく表示されない</li>
        </ul>
        <h2 class="text-secondary mt-4">1.0 <small class="date">2020/04/21</small></h2>
        <p>
            「National Economy Online」を公開しました。
        </p>
    </div>
</template>
<style scoped>
.date {
    margin-left: 1rem;
}
</style>
