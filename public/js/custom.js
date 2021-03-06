/* MD Disapprove expense, comment and send notification module         */
    $(document).ready(function () {
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
                data: {id: id},
                dataType: "json",
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
                   $('.alert').show();
                   $('.alert').html(response.message).fadeOut(5000);
                   window.location.reload();
                }
            });

            }
        });

        $('body').on('click', '.edit-form', function(){

            let id = $(this).data('id');
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
        })

        $('body').on('click', '#btn-cfo', function(event){

            let id = $('#id').val()
            let comment = $('#cfoComment').val();
            if (comment=="") {
                let message = "Please this field is required";
                $('#error').show().html(message).css({'color':'red'}).fadeOut(3000);

            }else{
                $('#btn-cfo').html('Please wait...').attr('disabled', true);


            }

        })
    });




