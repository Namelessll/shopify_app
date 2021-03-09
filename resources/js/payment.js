function payPlan() {
    e.preventDefault();
    var bodyFormData = new FormData();
    bodyFormData.set('plan', '1');

    axios({
        method: 'post',
        url: '/plans/pay',
        data: bodyFormData,
        headers: {'Content-Type': 'multipart/form-data' }
    })
    .then(function (response) {
        console.log(response);
    })
    .catch(function (response) {
        console.log(response); 
    });
}