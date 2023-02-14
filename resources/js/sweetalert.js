import swal from 'sweetalert2'
var address = "http://127.0.0.1:8000/"
export const success_response = function(data, redirect = false, redirect_page) {
    if (redirect) {
        new swal({
            title: "Success!",
            icon: "success",
            text: data,
            button: 'OK',
        }).then((result) => {
            window.location.href = address + redirect_page;
        })
    } else {
        new swal({
            title: "Success!",
            icon: "success",
            text: data,
            button: 'OK',
        })
    }
  }

  export const warning_response = function(data, redirect = false, redirect_page) {
    if (redirect) {
        if (data != "checking") {
            new swal({
                title: "Warning!",
                icon: "warning",
                text: data,
                button: 'OK',
            }).then((result) => {
                window.location.href = address + redirect_page;
            })
        }
    } else {
        if (data != "warning") {
            new swal({
                title: "Warning!",
                icon: "warning",
                text: data,
                button: 'OK',
            })
        }
    }
  }

  export const error_response = function() {
    new swal({
        title: "Error!",
        icon: "error",
        text: 'Something Error !',
        button: 'OK',
    })
  }
  
