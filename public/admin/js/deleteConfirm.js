//nhan delete
function confirmDelete(id, url, ){
    // const url = '/admin/category/' + id + '/delete';
    const modal = '#deleteModal' + id;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');//chuỗi mã

    //capcha : truyen widget cu the de nhan phan hoi
    var recaptchaResponse = grecaptcha.getResponse(recaptchaList[id]);

    if (!recaptchaResponse) {
        alert('Please complete the CAPTCHA.');
        return;
    }
    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        },
        //capcha
        body: JSON.stringify({
            recaptcha_response: recaptchaResponse
        })
    })
    .then(response => {
        // Kiểm tra phản hồi có OK (status 200-299) hay không
        if (!response.ok) {
            throw new Error('Network response was not ok.');
        }
        // Trả về JSON nếu thành công
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Xóa dòng category khỏi bảng
            document.getElementById('item_' + id).remove();
            // Đóng modal
            $(modal).modal('hide');
            // Thông báo thành công
            alert(data.message);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Something went wrong.');
        console.error('Error:', error);
    });
}
//hien thi widget tren trang
function createCaptcha(id){
    //create 1 widget
    let widget = grecaptcha.render('recaptcha_'+id, {
        sitekey: '6Ld8vGMqAAAAAA-JUbpmbSCPRYdhLNrS-NwQnV7A',
    })
    //push widget to list
    recaptchaList[id] = widget;
}

//luu cac widget vao doi tuong
let recaptchaList = {};

//nhan phan hoi tu widget ---> test
function responseCaptcha(id){
    let responseCaptcha = grecaptcha.getResponse(recaptchaList[id]);
    console.log(responseCaptcha);
    //... code xử lý phản hồi từ widget CAPTCHA...xu ly o model hoac api

}
