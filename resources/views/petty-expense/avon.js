jQuery(document).ready(function($){
    var next_page ;
    var pre_page  ;
    var rows ;
    var detail = '';
    var page ;
    var api_result;
    
   $.ajax({
       url: '/wp-json/avon/avon-provider'
   }).done(function(data){
      // var rows ;
     //  console.log(data.lstplanbenefitdetails[0]['ProviderName']);
     api_result = data.lstplanbenefitdetails;
        results = Paginator(api_result);
     console.log(data.lstplanbenefitdetails);
     
     page= results.page;
     next_page = results.next_page;
     pre_page = results.pre_page;
     rows = results.per_page;
     total_pages = results.total_pages;
    $('#text-sm').html('Page '+ page + ' of ' + total_pages);
     
     $('#per_page').val(rows);
     
     
   // showData(results);
   
   $.each(results.data, function(key, value){
         // detail +='<tbody>'
          detail += '<tr>';
          detail += '<td>' + value.ProviderNo + '</td>';
          detail += '<td>' + value.ProviderName + '</td>';
          detail += '<td>' + '<b>' + value.ProviderClass + '</b>'+ '</td>';
          detail += '</tr>';
         // detail += '</tbody>'
      });
          $('table tbody').append(detail);
     
      });
      
      
    function Paginator(items, page, per_page) {

          var page = page || 1,
          per_page = per_page || 10,
          offset = (page - 1) * per_page,
        
          paginatedItems = items.slice(offset).slice(0, per_page),
          total_pages = Math.ceil(items.length / per_page);
          return {
          page: page,
          per_page: per_page,
          pre_page: page - 1 ? page - 1 : null,
          next_page: (total_pages > page) ? page + 1 : null,
          total: items.length,
          total_pages: total_pages,
          data: paginatedItems
          };
}
  
  
  
  function showData(items){
        $.each(items, function(key, value){
         // detail +='<tbody>'
          detail += '<tr>';
          detail += '<td>' + value.ProviderNo + '</td>';
          detail += '<td>' + value.ProviderName + '</td>';
          detail += '<td>' + '<b>' + value.ProviderClass + '</b>'+ '</td>';
          detail += '</tr>';
        //  detail += '</tbody>'
      });
          $('table tbody').append(detail);
      
  }
  
  // Show next data.
  
  $('body').on('click', '#next_p', function(){
       
    //  console.log(next_page);
       $('#text-sm').html('Page '+ next_page + ' of ' + total_pages);
     // 
     
     console.log(next_page);
     console.log(api_result);
     
     next_results = Paginator(api_result,next_page);
     
     console.log(next_results)
     page = next_results.page;
     pre_page = next_results.pre_page;
     next_page = next_results.next_page;
     console.log(next_results.data);
    
     $.each(next_results.data, function(key, value){
        // detail +='<tbody>'
          detail += '<tr>';
          detail += '<td>' + value.ProviderNo + '</td>';
          detail += '<td>' + value.ProviderName + '</td>';
          detail += '<td>' + '<b>' + value.ProviderClass + '</b>'+ '</td>';
          detail += '</tr>';
        //  detail += '</tbody>'
        
      });
      clearTable();
          $('table tbody').append(detail);
     
     
   //  showData(next_results.data);
   
      
  });
  
  function clearTable(){
         $('#tbody-avon tr').remove();
     }
  
  // Show Previous data.
  $('body').on('click', "#prev_p", function(){
      
       $('#text-sm').html('Page '+ pre_page + ' of ' + total_pages);
      $.ajax({
       url: '/wp-json/avon/avon-provider'
   }).done(function(data){
      // var rows ;
     //  console.log(data.lstplanbenefitdetails[0]['ProviderName']);
     var results = (Paginator(data.lstplanbenefitdetails,pre_page));
     
   //  console.log(results.data);
      next_page = results.next_page;
      pre_page = results.pre_page;
     
   // showData(results);
      
      
  });
  
  
       
});

// Search for a provider
$('body').on('click', '#api-button', function(){
    var search_key = $('#search-key').val();
   // console.log(search_key);
    
    $.ajax({
       url: '/wp-json/avon/avon-provider'
   }).done(function(data){
      // var rows ;
     //  console.log(data.lstplanbenefitdetails[0]['ProviderName']);
     var results = Paginator(data.lstplanbenefitdetails);
     
     results.data = $.map(results.data,function(val,key) {
              if(val.ProviderName == search_key) return val;
           });
           
           console.log(results.data);
     
     page= results.page;
     next_page = results.next_page;
     pre_page = results.pre_page;
     rows = results.per_page;
     total_pages = results.total_pages;
    $('#text-sm').html('Page '+ page + ' of ' + total_pages);
     
     $('#per_page').val(rows);
     
     
   // showData(results);
     
      });
    
})

});



