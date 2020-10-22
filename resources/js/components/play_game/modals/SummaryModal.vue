<template>
    <div class="modal fade" id="summaryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">サマリー</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ラウンド</th>
                                <th scope="col">賃金</th>
                                <th scope="col">建物</th>
                                <th scope="col">機能</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr :class="{'table-info': this.game.round === 1 || false}">
                                <th scope="row">1</th>
                                <td>$2</td>
                                <td>採石場・学校・大工・鉱山<span v-if="needsRuin">・遺跡</span></td>
                                <td>建物カードを参照</td>
                            </tr>
                            <tr :class="{'table-info': this.game.round === 2 || false}">
                                <th scope="row">2</th>
                                <td>$2</td>
                                <td>露店</td>
                                <td>1枚捨てて家計から$6獲得</td>
                            </tr>
                            <tr :class="{'table-info': this.game.round === 3 || false}">
                                <th scope="row">3</th>
                                <td>$3</td>
                                <td>市場</td>
                                <td>2枚捨てて家計から$12獲得</td>
                            </tr>
                            <tr :class="{'table-info': this.game.round === 4 || false}">
                                <th scope="row">4</th>
                                <td>$3</td>
                                <td>高等学校</td>
                                <td>労働者を4人に増やす</td>
                            </tr>
                            <tr :class="{'table-info': this.game.round === 5 || false}">
                                <th scope="row">5</th>
                                <td>$3</td>
                                <td>スーパーマーケット</td>
                                <td>3枚捨てて家計から$18獲得</td>
                            </tr>
                            <tr :class="{'table-info': this.game.round === 6 || false}">
                                <th scope="row">6</th>
                                <td>$4</td>
                                <td>大学</td>
                                <td>労働者を5人に増やす</td>
                            </tr>
                            <tr :class="{'table-info': this.game.round === 7 || false}">
                                <th scope="row">7</th>
                                <td>$4</td>
                                <td>百貨店</td>
                                <td>4枚捨てて家計から$24獲得</td>
                            </tr>
                            <tr :class="{'table-info': this.game.round === 8 || false}">
                                <th scope="row">8</th>
                                <td>$5</td>
                                <td>専門学校</td>
                                <td>すぐ使える労働者を1人追加</td>
                            </tr>
                            <tr :class="{'table-info': this.game.round === 9 || false}">
                                <th scope="row">9</th>
                                <td>$5</td>
                                <td>万博</td>
                                <td>5枚捨てて家計から$30獲得</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Modal from '../../../mixins/modal'

export default {
    props: ['game'],
    mixins: [Modal],
    computed: {
        needsRuin() {
            return this.game.type === 'glory' || this.game.type === 'mix'
        }
    }
}
</script>
