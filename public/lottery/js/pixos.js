class Pixos {
	constructor(url, data) {
		this.url = url;
		this.data = data;
	}
	ajax() {
		$.ajax({
			type: "Post",
			url: this.url,
			data: this.data,
			contentType: "application/json; charset=utf-8",
			dataType: "json", //表示后台返回的数据是json对象
			success: function(data) {
				
			},
			error: function(error) {
				alert("error=" + error);
			}
		});
	}

}
var pixos = new Pixos(url, data);
pixos.ajax()