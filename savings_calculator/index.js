Vue.component('modal', {
    template: '#modal-template'
});
const app = new Vue({
    el: '#app',
    created: function () {
        return fetch("savings_calculator/storage/storage.json")
            .then(response => response.json())
            .then(data => app.products = data);
    },
    data: {
        products: [],
        message: 'Savings calculator',
        newSaving: {
            fund: '',
            oneTimeInvestment: '',
            totalIncome: '',
            netIncome: '',
            interestIncome: '',
            taxes: '',
            years: '',
            email: ''
        },
        calculated: false,
        appliedSavings: [],
        selectedSaving: '',
        showModal: false,
        reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/

    },
    mounted: function () {
        if (localStorage.getItem('appliedSavings')) {
            try {
                this.appliedSavings = JSON.parse(localStorage.getItem('appliedSavings'));
            } catch (e) {
                localStorage.removeItem('appliedSavings');
            }
        }
    },
    computed: {
        savingButtonDisabled: function () {
            return !(
                this.newSaving.fund &&
                this.newSaving.oneTimeInvestment &&
                this.newSaving.years &&
                this.isEmailValid === 'success'
            );
        },
        isEmailValid: function () {
            return (this.newSaving.email == "") ? "" : (this.reg.test(this.newSaving.email)) ? 'success' : 'error';
        }
    },


    methods: {
        calculate: function () {
            if (validate(this.newSaving)) {
                this.newSaving.totalIncome = calculateFinalSaving(
                    this.newSaving.oneTimeInvestment,
                    this.newSaving.fund.interestRate,
                    this.newSaving.years
                );

                this.newSaving.interestIncome =
                    this.newSaving.totalIncome -
                    this.newSaving.oneTimeInvestment;

                this.newSaving.taxes = calculateTaxes(this.newSaving.interestIncome);
                this.newSaving.netIncome = this.newSaving.totalIncome -
                    this.newSaving.taxes;
                this.calculated = true;
            }
        },
        applyForSaving: function () {
            if (validate(this.newSaving)) {
                const configurationToAdd = {
                    selectedFund: this.newSaving.fund,
                    years: this.newSaving.years,
                    oneTimeInvestment: this.newSaving.oneTimeInvestment,
                    totalIncome: this.newSaving.totalIncome,
                    email: this.newSaving.email,
                    netIncome: this.newSaving.netIncome,
                    taxes: this.newSaving.taxes,
                    interestIncome: this.newSaving.interestIncome,
                };
                this.appliedSavings.unshift(configurationToAdd);

                this.newSaving.fund = '';
                this.newSaving.oneTimeInvestment = '';
                this.newSaving.years = '';
                this.newSaving.totalIncome = '';
                this.newSaving.netIncome = '';
                this.newSaving.interestIncome = '';
                this.newSaving.taxes = '';
                this.newSaving.email = '';
                this.calculated = false;
                this.saveAppliedSavings();

            }

        },
        round: function (input) {
            return Math.round(input * 100) / 100
        },
        format: function (number) {
            return parseFloat(number).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1 ');

        },
        openDetail: function (saving) {
            this.selectedSaving = saving;
            this.showModal = true;
        },
        saveAppliedSavings() {
            const parsed = JSON.stringify(this.appliedSavings);
            localStorage.setItem('appliedSavings', parsed);
        },
        removeSaving(appliedSaving) {
            const index = this.appliedSavings.indexOf(appliedSaving);
            this.$delete(this.appliedSavings, index);
            this.saveAppliedSavings();
        },
    }
});


function validate(newSaving) {
    return (newSaving.fund && newSaving.oneTimeInvestment && newSaving.years);
}

function calculateFinalSaving(initialInvestment, interestRate, years) {
    return initialInvestment * Math.pow(1 + (+interestRate / 100), +years)
}

function calculateTaxes(input) {
    return input * 0.19;
}
