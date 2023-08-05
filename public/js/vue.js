(function() {
  new Vue({
    el:"#clock",
    data(){
        return{
            date:new Date(),
        };
    },
    mounted(){
        //現在日時をセット
        this.setDate();
        //一秒ごとにsetDate()を実行
        // setInterval(function(){this.setDate(),1000});
        setInterval(() => this.setDate(),1000);
    },
    methods:{
        //日時を二桁に変換
        dateTimePadding(num){
            return ("0" +num).slice(-2);
        },
        //現在日時をセット
        setDate(){
            this.date = new Date();
        }
    },
    //算出プロパティ
    computed:{
        //年
        year(){
            var data = this.date.getFullYear();
            return data;
        },
        //月
        month(){
            return this.date.getMonth()+1;
        },
        //日
        day(){
            return this.date.getDate();
        },
        //時
        hours(){
            return this.dateTimePadding(this.date.getHours());
        },
        //分
        minutes(){
            return this.dateTimePadding(this.date.getMinutes());
        },
        //秒
        seconds(){
            return this.dateTimePadding(this.date.getSeconds());
        }
    }
  });

  new Vue({
    el: '.user_create',
    data: {
      postCode:"",
    },
  watch: {
    postCode: function (newVal,oldval) {
      
      if(newVal.indexOf("-")===3 && newVal.length<=8){
        this.postCode = newVal;
      }
      else if (isNaN(newVal) || newVal.length>8){
        this.postCode = oldval;
      }
      else{
        this.postCode = newVal;
      }
      return false;
    },
  },
  });
})();
