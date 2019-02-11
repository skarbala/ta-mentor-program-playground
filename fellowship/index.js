const pointsLeft = 25;
const app = new Vue({
    el: '#app',
    created: function () {
        return fetch("fellowship/storage/storage.json")
            .then(response => response.json())
            .then(data => app.fellows = data);
    },
    data: {
        pointsLeft: pointsLeft,
        fellows: [],
        selectedFellows: []
    },
    methods: {
        clickOne: function (fellow) {
            if (this.selectedFellows.includes(fellow)) {
                this.selectedFellows.splice(this.selectedFellows.indexOf(fellow), 1);
                this.pointsLeft = this.pointsLeft + fellow.score;
            }
            else if (this.pointsLeft - fellow.score >= 0) {
                this.pointsLeft = this.pointsLeft - fellow.score;
                fellow.selected = true;
                this.selectedFellows.push(fellow);
            }
        }
    }

});