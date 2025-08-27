<template>
    <div>
      <div class="row flex-table">
          <div class="col-sm-4 col-md-4 col-lg-4"><h6>Narrative</h6></div>
          <div class="col-sm-2 col-md-2 col-lg-2" v-if="type !== 'Internal'"><h6>Unit</h6></div>
          <div class="col-sm-1 col-md-1 col-lg-1"><h6>Qty</h6></div>
          <div class="col-sm-1 col-md-1 col-lg-1" v-if="type !== 'Internal'"><h6>Disc</h6></div>
          <div class="col-sm-1  col-md-1 col-lg-1" v-if="type !== 'Internal'"><h6>Tax</h6></div>
          <div class="col-sm-2 col-md-2 col-lg-2" v-if="type !== 'Internal'"><h6>Amount</h6></div>
          <div class="col-sm-1 col-md-1 col-lg-1"></div>
      </div>

      <div class="row flex-table" v-for="(documentItem, index) in documentItems">
          <div class="col-sm-4 col-md-4 col-lg-4">{{documentItem.description | capitalize}}</div>
          <div class="col-sm-2 col-md-2 col-lg-2" v-if="type !== 'Internal'">{{documentItem.unit}}</div>
          <div class="col-sm-1 col-md-1 col-lg-1">{{documentItem.quantity}}</div>
          <div class="col-sm-1 col-md-1 col-lg-1" v-if="type !== 'Internal'">{{documentItem.discount}}</div>
          <div class="col-sm-1  col-md-1 col-lg-1" v-if="type !== 'Internal'">{{documentItem.tax_amount}}</div>
          <div class="col-sm-2 col-md-2 col-lg-2" v-if="type !== 'Internal'">{{documentItem.amount}}</div>
          <div class="col-sm-1 col-md-1 col-lg-1 p-0">
              <div class=" p-0 grey">
                  <button class="btn btn-sm p-1 py-0" @click.prevent="editDocumentItem(index)"><i class="fa fa-edit"></i></button>
                  <button class="btn btn-sm p-1 py-0" @click.prevent="removeDocumentItem(index)"><i class="fa fa-trash"></i></button>
              </div>
          </div>
      </div>

      <div class="row item-entry gx-2">
          <div class="col-sm-4 col-md-4 col-lg-4">
              <div class="form-group">
                  <!-- <label class="only-mobile">Item</label> -->
                  <v-select :options="items" label="name" :reduce="item => item.id"  v-model="itemData.item_id" @input="getUnit" class="style-chooser" @search="searchItems" placeholder="Select item"></v-select>
                  <div v-if="errors.item_id"><span class="text-danger" role="alert">{{errors.item_id[0]}}</span></div>
              </div>
              <div class="form-group mt-2">
                  <!-- <label class="only-mobile">Description</label> -->
                  <textarea name="description" v-model="itemData.description" class="form-control line-input" rows="2"></textarea>
                  <div v-if="errors.description"><span class="text-danger" role="alert">{{errors.description[0]}}</span></div>
              </div>
          </div>
          <div class="form-group col-sm-2 col-md-2 col-lg-2" v-if="type !== 'Internal'">
              <!-- <label class="only-mobile">Unit price</label> -->
              <input type="number" name="unit" v-model="itemData.unit" class="form-control line-input"  min="0" step="0.01" placeholder="0.00" v-on:input="calculate">
              <div v-if="errors.unit"><span class="text-danger" role="alert">{{errors.unit[0]}}</span></div>
          </div>
          <div class="form-group col-sm-1 col-md-1 col-lg-1">
              <!-- <label class="only-mobile">Qty</label> -->
              <input type="number" name="quantity" v-model="itemData.quantity" class="form-control line-input px-1" v-on:input="calculate" min="0" step="1">
              <div v-if="errors.quantity"><span class="text-danger" role="alert">{{errors.quantity[0]}}</span></div>
          </div>
          <div class="form-group col-sm-1 col-md-1 col-lg-1" v-if="type !== 'Internal'">
              <!-- <label class="only-mobile">Discount</label> -->
              <input type="number" name="discount" v-model="itemData.discount" class="form-control line-input px-1"  min="0" step="1" placeholder="0.00" v-on:input="calculate">
              <div v-if="errors.discount"><span class="text-danger" role="alert">{{errors.discount[0]}}</span></div>
             <input class="form-check-input" type="checkbox" value="1" v-model='itemData.is_percentage' checked true-value="1" false-value="0"  v-on:change="calculate">
              <label style="font-size:12px;">%</label>
          </div>
          <div class="form-group col-sm-1  col-md-1 col-lg-1" v-if="type !== 'Internal'">
              <!-- <label class="only-mobile">Tax</label> -->
              <select name="tax_id" v-model="itemData.tax_id" class="form-select px-1 line-input" v-on:change="calculate">
                  <option value="">Select</option>
                  <option v-for="tax in taxes" :value="tax.id" :key="tax.id">{{tax.name}}</option>
              </select>
              <div v-if="errors.tax_id"><span class="text-danger" role="alert">{{errors.tax_id[0]}}</span></div>
          </div>
          <div class="form-group col-sm-2 col-md-2 col-lg-2" v-if="type !== 'Internal'">
              <!-- <label class="only-mobile">Amount</label> -->
              <input type="number" name="amount" v-model="itemData.amount" class="form-control line-input"  min="0" step="0.01" placeholder="0.00" readonly v-on:input="calculate">
              <div v-if="errors.amount"><span class="text-danger" role="alert">{{errors.amount[0]}}</span></div>
          </div>
          <div class="form-group col-sm-1 col-md-1 col-lg-1">
              <button  class="btn btn-sm btn-warning w-100" @click.prevent="saveDocumentItem" :disabled="itemData.amount<=0"><i class="fa fa-plus"></i></button>
          </div>
      </div>

    </div>
    </template>

  <script>
      import Network from "../network-class";

      export default {
        name:'documentItem',
          created(){
            this.getTaxes();
            this.documentItems=this.starterItems;
          },
          updated(){
          },
          destroyed () {
          },
          data:() => ({
            documentItems:[],
            ledgerAccounts:[],
            taxes:[],
            errors:[],
            items:[],
            itemData:{
                        name:'',
                        item_id:null,
                        ledger_account_id:null,
                        inventory_id:null,
                        service_id:null,
                        package_id:null,
                        tax_id:null,
                        description:'',
                        unit:0.00,
                        quantity:1,
                        subtotal:0,
                        discount:0,
                        tax_amount:0,
                        amount:0,
                        is_percentage:null,
                    },
          }),
          methods: {
            calculate: async function (event) {
              var subtotal = this.calculateItemSubtotal();
              var discount = await this.calculateDiscount(subtotal);
              var amount = subtotal - discount;
              
              if (this.itemData.tax_id != null) {
                var tax_amount = await this.calculateTax(amount);
              } else {
                var tax_amount = 0.00;
              }

              // Now, check if tax_amount is a number (valid) before updating this.itemData.tax_amount.
              if (!isNaN(tax_amount)) {
                this.itemData.tax_amount = tax_amount;
              } else {
                this.itemData.tax_amount = 0.00;
              }
              
              // Check if amount is a number (valid) before updating this.itemData.amount.
              if (!isNaN(amount)) {
                this.itemData.amount = (amount + this.itemData.tax_amount).toFixed(2);
              } else {
                this.itemData.amount = this.itemData.tax_amount.toFixed(2);
              }
            },
            calculateItemSubtotal: function () {
              var subtotal=this.itemData.unit*this.itemData.quantity;
              return subtotal;
            },
            calculateDiscount: async function (amount) {
              var discount;
             if(this.itemData.is_percentage==1){
                  discount=this.itemData.discount*amount/100;
              }
              else{
                  discount=this.itemData.discount
              }
              return discount;
            },
            calculateTax: async function (amount) {
              var url='/api/tax/'+this.itemData.tax_id;
              const data = await Network.get(url);
              var tax=data.data;
              var tax_amount=amount*tax.rate/100;
              return Math.round(tax_amount);
            },
            searchItems: async function (search, loading) {
                var url='/api/searchItems/'+search;
                const data = await Network.get(url);

                if (Array.isArray(data)) {
                  this.items=data.map(function (item){ return {name:item.name, id:item.prefixed_id}});
                }else {
                  // Handle the case where data is not an array (e.g., show an error message).
                  // You can add your error handling logic here.
                }
            },
            getTaxes: async function () {
                var url='/api/taxes';
                const data = await Network.get(url);
                this.taxes=data.taxes;
            },
            getService: async function (id) {
              var url='/api/service/'+id;
              const data = await Network.get(url);
              return data.data;
            },
            getPackage: async function (id) {
              var url='/api/package/'+id;
              const data = await Network.get(url);
              return data.data;
            },
            getInventory: async function (id) {
              var url='/api/inventory/'+id;
              const data = await Network.get(url);
              return data.data;
            },
            getUnit: async function () {
              var itemArray=this.itemData.item_id.split("#");
              if(itemArray[0]=='INV'){
                  var inventory=await this.getInventory(itemArray[1]);
                  this.itemData.inventory_id=inventory.id;
                  this.itemData.description=inventory.name;
                  this.itemData.unit=inventory.sale_price;
                  this.itemData.name=inventory.name;
              }
              else if(itemArray[0]=='SRV'){
                  var service=await this.getService(itemArray[1]);
                  this.itemData.service_id=service.id;
                  this.itemData.description=service.name;
                  this.itemData.unit=service.price;
                  this.itemData.name=service.name;
              }
              else if(itemArray[0]=='PKG'){
                  var packagy=await this.getPackage(itemArray[1]);
                  this.itemData.package_id=packagy.id;
                  this.itemData.description=packagy.name;
                  this.itemData.unit=packagy.price;
                  this.itemData.name=packagy.name;
              }
              this.calculate();
            },
            saveDocumentItem: async function () {
              this.itemData.subtotal=this.calculateItemSubtotal();
              this.itemData.discount=await this.calculateDiscount(this.itemData.subtotal);
              this.documentItems.push(this.itemData);
              this.itemData={name:null, item_id:null, inventory_id:null, service_id:null, package_id:null, tax_id:null, tax_amount:0.00, description:null, unit:0.00, quantity:1, discount:0.00, amount:0.00, is_percentage:null};
              this.$emit('documentItems',this.documentItems);
            },
            removeDocumentItem: async function (index) {
              if(this.documentItems!=null){
              this.documentItems.splice( index, 1);}
              this.$emit('documentItems',this.documentItems);
            },
            editDocumentItem: async function (index) {
              if(this.documentItems!=null){
              this.itemData=this.documentItems[index];
              this.itemData.is_percentage=0;
              this.documentItems.splice( index, 1);}
              this.$emit('documentItems',this.documentItems);
            },
          },
          props: {
            document: {type: [String], required: true},
            starterItems: {type: [Array], required: false,},
            type: {type: [String], required: false},
            },
          computed: {

          },

          watch: {
            starterItems: {
                handler(newVal) {
                    this.documentItems = newVal;
                },
                immediate: true,
                deep: true,
            },
        },
      }
  </script>
