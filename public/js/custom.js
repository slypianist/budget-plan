/* MD Disapprove expense, comment and send notification module         */
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Show Comment form for MD
        $('body').on('click', '.edit', function(){
            let id =  $(this).data('id');
            $('#addCommentForm').trigger("reset");

            $.ajax({
                type: "post",
                url: `${id}/show`,
/*                 data: {id: id},
 */                dataType: "json",
                success: function (response) {
                    $('#comment-model').modal('show');
                    $('#comTitle').html('Add Comment');
                    $('#comLbl').html('MD Comment')
                   $('#id').val(response.id)
                }
            });
        });

        // Save form.
        $('body').on('click', '#btn-save', function(event){
            let id = $('#id').val();
            let comment = $('#comment').val();
           let a = event.target;
            if (comment =="") {
                let message = "The comment field is required " + a;
                $('#error').show();

                   $('#error').html(message).css({"color": "red"}).fadeOut(2000);

            } else {
                $('#btn-save').html('Please wait...');
            $('#btn-save').attr('disabled', true);
          //  console.log(id);
            $.ajax({
                type: "post",
                url: `${id}/md-comment`,
                data: {comment: comment},
                dataType: "json",
                success: function (response) {
                   $('#btn-save').html('Add comment');
                   $('btn-save').attr('disabled', false);
                   window.alert(response.message);
                   window.location.reload();
                }
            });

            }
        });

        

    });

    $(function () {

        $('body').on('click', '.edit-form', function(){

            let id = $(this).data('expid');
            $('#addCfoForm').trigger('reset');

            $.ajax({
                type: "post",
                url: `${id}/show`,
                data: {id:id},
                dataType: "json",
                success: function (res) {
                    $('#cfo-comment-model').modal("show");
                    $('#cfoTitle').html('Add your comment');
                    $('#cfoLbl').html('Substantive comment');
                    $('#id').val(res.id);

                }
            });
        });

        $('body').on('click', '#btn-cfo', function(event){
          //  console.log("Working");

            let id = $('#id').val();
            let comments = $('#com').val();
            let b = event.target;
           // console.log(b);
            if(comments==""){
                let mgs = "Please this field is required." + b;
                $('#errors').show().html(mgs).css({"color": "red"}).fadeOut(3000);
                
            }else{
               
                $('#btn-cfo').html('Please wait...');
                $('#btn-cfo').attr('disabled', true);

                $.ajax({
                    type: "post",
                    url: `${id}/cfo-comment`,
                    data: {comment:comments},
                    dataType: "json",
                    success: function (res) {
                        $('#btn-cfo').html('Add comment')
                        .attr('disabled', false);
                        window.alert(res.message);
                        window.location.reload();  
                    }, 
                    error: function(){
                        window.alert("An error occurred. Please try again");

                    }
                });
            }
        });

        // Set Expense payment status to Paid.

$('.pay').on('click', function (e) {
    let test = $(this).data('status')
  let states =  $(this).hide().next().show();

    $.ajax({
        type: "patch",
        url: `/expenses/expense/${test}/pay`,
        data: {id:test},
        dataType: "json",
        success: function (response) {
            $('.pstatus').html(response.payment_status)
            
            window.alert(response.payment_status)
           // window.location.reload();
            
        },
        complete: function(){
            $('.loader').hide();
            $('.pstatus').show();
           
        }
    });
    
      
    });
        
});




