
    var licence = document.getElementById("licence");
    var licenceAddRow = document.getElementById("licenceAddRow");
    var licenceTextareaList = licence.querySelectorAll('textarea');
    var downloadBtn = document.getElementById('download');
    var licenceDownload = document.getElementById('licenceDownload');

// DOMContentLoaded 事件监听器
    document.addEventListener('DOMContentLoaded', function () {
        populateTable('', 'licence')
        // 檔案上傳事件
        handleFormSubmit('licence');

    });

    // 自動填寫編號並計算 <tbody> 中的 <tr> 數量
    function updateRowNumbers(tableId) {
        let tbody = document.querySelector(`#${tableId} tbody`);
        let rows = tbody.querySelectorAll('tr');

        // 更新編號
        rows.forEach(function (row, index) {
            let noCell = row.querySelector('td:first-child');
            noCell.textContent = index + 1;
        });
    }

    function populateTable(response, tableId) {
        // 获取表格的 tbody 元素fuelCompositionTbody
        // 注意，因為.append是JQ語言，所以以下這段皆屬於JQ語言。
        var tbody = $('#'+tableId+'Tbody');
        // let tbody = document.querySelector(`#${tableId} tbody`);
        var numberCount = 1;
        tbody.empty(); 
        // 清空表格中的内容，以防重复填充
        var resetButton = document.getElementById(tableId +'Reset');

        if(response == ''){
            var newRow = $('<tr>');
            newRow.append('<td colspan="11" style="color: blue; font-weight: bold;">請匯入資料！</td>');
            tbody.append(newRow);

        }else if(response == '皆無異動' ){
            var newRow = $('<tr>');
            newRow.append('<td colspan="11" style="color: blue; font-weight: bold;">' + response + '</td>');
            tbody.append(newRow);

        }else{
            response.forEach(function(row) {
                    let warningCheck = '';
                    if(tableId == 'licence'){
                        if(row['比對'] == '請確認'){
                            warningCheck = 'error';
                        }
                        var newRow = $('<tr>');
                        newRow.append('<td>' + numberCount + '</td>');
                        newRow.append('<td>' + row['工號'] + '</td>');
                        newRow.append('<td>' + row['姓名'] + '</td>');
                        newRow.append('<td class = "' + warningCheck + '">' + row['單位代碼'] + '</td>');
                        newRow.append('<td class = "' + warningCheck + '">' + row['Hr單位代碼'] + '</td>');
                        newRow.append('<td>' + row['掛證單位代碼'] + '</td>');
                        newRow.append('<td>' + row['掛證棟別'] + '</td>');
                        newRow.append('<td>' + row['掛證廠別'] + '</td>');
                        newRow.append('<td>' + row['掛證單位名稱'] + '</td>');
                        newRow.append('<td>' + row['證照名稱'] + '</td>');
                        newRow.append('<td class = "' + warningCheck + '" >' + row['比對'] + '</td>');
                        newRow.append('</tr>');
                    }
                
                tbody.append(newRow);
                numberCount++;
                    
                // 更新行号
                updateRowNumbers(tableId);

            });
        }

        resetButton.click();
        // console.log(downloadBtn);
        downloadBtn.removeAttribute('disabled');
    }

// 函数来处理表单提交
    function handleFormSubmit(tableId) {
        var form = document.getElementById(tableId + 'Form');
        var file = document.getElementById(tableId + 'File');
        var fileString = tableId + 'File';

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            mloading();
            let formData = new FormData();
            formData.append(fileString, file.files[0]);
            $.ajax({
                url: 'ajax_excel.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // 处理后端返回的数据
                    console.log(response);
                    var jsonString = JSON.stringify(response);
                    licenceDownload.innerText = jsonString;
                    populateTable(response, tableId);
                    hideLoading();
                },
                error: function(xhr, status, error) {
                    console.error('上传失败');
                    hideLoading();
                }
            });
        });
    }

// mloading function
    function mloading(){
        $("body").mLoading({    // 開啟loading
            icon: "../../libs/jquery/Wedges-3s-120px.gif",
        }); 
    }

// 關閉mLoading提示
    function hideLoading(){
        $("body").mLoading("hide");
    }
