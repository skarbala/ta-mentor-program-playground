<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Savings Calculator</title>
  <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Exo:300i|Russo+One" rel="stylesheet">
  <link rel="stylesheet" href="savings_calculator/style.css">
</head>
<body>
<?php include 'partials/navbar.php' ?>

<div id="app" class="container">
  <modal v-if="showModal" @close="showModal = false">
    <h2 slot="header">Saving request</h2>
    <div slot="body">
      <div class="row">
        <div class="col">
          <p>Investment<span>{{format(selectedSaving.oneTimeInvestment)}} kr</span></p>
          <p>Interest income<span>{{format(selectedSaving.interestIncome)}} kr</span></p>
          <p>Taxes<span>{{format(selectedSaving.taxes)}} kr</span></p>
        </div>
        <div class="col">
          <p>Fund<span>{{selectedSaving.selectedFund.name}}</span></p>
          <p>Risk<span>{{selectedSaving.selectedFund.risk}}</span></p>
          <p>Return<span>{{format(selectedSaving.selectedFund.interestRate)}} %</span></p>
          <p>Years<span>{{selectedSaving.years}}</span></p>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col modal-result">
          <p>Income before tax<span>{{format(selectedSaving.totalIncome)}} kr</span></p>
          <p>Income after tax<span>{{format(selectedSaving.netIncome)}} kr</span></p>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col modal-result">
          <p>Contact<span>{{selectedSaving.email}}</span></p>
        </div>
      </div>


    </div>
  </modal>
  <h1>Savings Calculator</h1>
  <div class="row">
    <div class="col">
      <h2>Request saving</h2>
      <div class="input-group mb-3">
        <select class="form-control"
                v-model="newSaving.fund"
                v-on:change="calculate()"
                id="fundSelect">
          <option value="" disabled selected>Select your fund</option>
          <option v-for="product in products" v-bind:value="product">{{ product.name }}</option>
        </select>
      </div>

      <div class="input-group mb-3">
        <input
          class="form-control"
          type="number"
          placeholder="One time investment"
          v-model="newSaving.oneTimeInvestment"
          step="1000"
          id="oneTimeInvestmentInput"
          v-on:change="calculate()">
      </div>

      <div class="input-group mb-3">
        <input class="form-control"
               type="number"
               placeholder="Period in years"
               v-model="newSaving.years"
               step="1"
               id="yearsInput"
               v-on:change="calculate()">
      </div>

      <div :class="['input-group mb-3', isEmailValid]">
        <input class="form-control"
               type="email"
               placeholder="Email address"
               v-model="newSaving.email"
               step="1"
               id="emailInput">
      </div>
      <button class="btn btn-block"
              v-on:click="applyForSaving()"
              v-bind:class="{ 'btn-success': !savingButtonDisabled }"
              :disabled="savingButtonDisabled">Apply for saving
      </button>
      <div class="result" v-if="calculated">
        <div>
          <p>{{format(newSaving.totalIncome)}} kr</p>
          <span>Total income</span>
        </div>
        <div>
          <p>{{format(newSaving.interestIncome)}} kr</p>
          <span>Interest income</span>
        </div>
        <div>
          <p>{{newSaving.fund.risk}}</p>
          <span>Risk</span>
        </div>
      </div>

    </div>

    <div class="col">
      <h2 class="recent-requests-header">Recent requests
        <span v-if="appliedSavings.length>0">{{appliedSavings.length}}</span></h2>
      <transition-group name="bounce" tag="ul" class="saving-list">
        <li v-for="appliedSaving in appliedSavings"
            v-bind:key="appliedSaving.email">
          <div class="saving-detail">
            <div class="row">
              <div class="col amounts">
                <p>Total income<span>{{format(appliedSaving.totalIncome)}} kr</span></p>
                <p>Net income <span>{{format(appliedSaving.netIncome)}} kr</span></p>
                <p>Taxes <span>{{format(appliedSaving.taxes)}} kr</span></p>
                <div class="buttons">
                  <button v-on:click="openDetail(appliedSaving)" class="saving-detail">detail</button>
                  <button v-on:click="removeSaving(appliedSaving)" class="remove-saving">remove</button>
                </div>
              </div>
              <div class="col">
                <p class="fund-description">{{appliedSaving.selectedFund.name}}</p>
                <p class="risk">{{appliedSaving.selectedFund.risk}}</p>

              </div>
            </div>

          </div>
        </li>
      </transition-group>

    </div>
  </div>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
<script src="savings_calculator/index.js"></script>
<script type="text/x-template" id="modal-template">
  <transition name="modal">
    <div class="modal-mask ">
      <div class="modal-wrapper">
        <div class="modal-container col-md-6">

          <div class="modal-header">
            <slot name="header">
              default header
            </slot>
          </div>

          <div class="modal-body">
            <slot name="body">
              default body
            </slot>
          </div>
          <div class="modal-footer">
            <slot name="footer">
              <button class="modal-default-button btn-block btn" @click="$emit('close')">
                Close
              </button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</script>
</html>