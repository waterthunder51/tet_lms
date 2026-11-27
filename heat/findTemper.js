// 1. 定義對照表
const temperatureHumidityLookup = {
    "26.7": { // 溫度 26.7
        "40": 26.7,
        "45": 26.7,
        "50": 27.2,
        "55": 27.2,
        "60": 27.8,
        "65": 27.8,
        "70": 28.3,
        "75": 28.9,
        "80": 28.9,
        "85": 29.4,
        "90": 30.0,
        "95": 30.0,
        "100": 30.6,
    },
    "27.8": { // 溫度 27.8
        "40": 27.2,
        "45": 27.8,
        "50": 28.3,
        "55": 28.9,
        "60": 28.9,
        "65": 29.4,
        "70": 30.0,
        "75": 31.1,
        "80": 31.7,
        "85": 32.2,
        "90": 32.8,
        "95": 33.9,
        "100": 35.0,
    },
    "28.9": { // 溫度 28.9
        "40": 28.3,
        "45": 28.9,
        "50": 29.4,
        "55": 30.0,
        "60": 31.1,
        "65": 31.7,
        "70": 32.2,
        "75": 33.3,
        "80": 34.4,
        "85": 35.6,
        "90": 36.7,
        "95": 37.8,
        "100": 39.4,
    },
    "30.0": { // 溫度 30.0
        "40": 29.4,
        "45": 30.6,
        "50": 31.1,
        "55": 31.7,
        "60": 32.8,
        "65": 33.9,
        "70": 35.0,
        "75": 36.1,
        "80": 37.8,
        "85": 38.9,
        "90": 40.6,
        "95": 42.2,
        "100": 44.4,
    },
    "31.1": {
        "40": 31.1,
        "45": 31.7,
        "50": 32.8,
        "55": 33.9,
        "60": 35.0,
        "65": 36.7,
        "70": 37.8,
        "75": 39.4,
        "80": 41.1,
        "85": 43.3,
        "90": 45.0,
        "95": 47.2,
        "100": 49.4,
    },
    "32.2": { 
        "40": 32.8,
        "45": 33.9,
        "50": 35.0,
        "55": 36.1,
        "60": 37.8,
        "65": 39.4,
        "70": 40.6,
        "75": 42.8,
        "80": 45.0,
        "85": 47.2,
        "90": 50.0,
        "95": 52.8,
        "100": 55.6,
    },
    "33.3": { 
        "40": 34.4,
        "45": 35.6,
        "50": 37.2,
        "55": 38.3,
        "60": 40.6,
        "65": 42.2,
        "70": 44.4,
        "75": 46.7,
        "80": 49.4,
        "85": 53.2,
        "90": 55.0,
        "95": 58.3,
        "100": 'Max',
    },
    "34.4": { 
        "40": 36.1,
        "45": 37.8,
        "50": 39.4,
        "55": 41.1,
        "60": 43.3,
        "65": 45.6,
        "70": 48.3,
        "75": 51.1,
        "80": 53.9,
        "85": 57.2,
        "90": 'Max',
        "95": 'Max',
        "100": 'Max',
    },
    "35.6": { 
        "40": 38.3,
        "45": 40.0,
        "50": 42.2,
        "55": 44.4,
        "60": 46.7,
        "65": 49.4,
        "70": 52.2,
        "75": 55.6,
        "80": 58.9,
        "85": 'Max',
        "90": 'Max',
        "95": 'Max',
        "100": 'Max',
    },
    "36.7": { 
        "40": 40.6,
        "45": 42.8,
        "50": 45.0,
        "55": 47.2,
        "60": 50.6,
        "65": 53.3,
        "70": 56.7,
        "75": 'Max',
        "80": 'Max',
        "85": 'Max',
        "90": 'Max',
        "95": 'Max',
        "100": 'Max',
    },
    "37.8": { 
        "40": 42.8,
        "45": 45.6,
        "50": 47.8,
        "55": 51.1,
        "60": 53.9,
        "65": 57.8,
        "70": 'Max',
        "75": 'Max',
        "80": 'Max',
        "85": 'Max',
        "90": 'Max',
        "95": 'Max',
        "100": 'Max',
    },
    "38.9": { 
        "40": 45.6,
        "45": 48.3,
        "50": 51.1,
        "55": 54.4,
        "60": 58.3,
        "65": 'Max',
        "70": 'Max',
        "75": 'Max',
        "80": 'Max',
        "85": 'Max',
        "90": 'Max',
        "95": 'Max',
        "100": 'Max',
    },
    "40.0": { 
        "40": 48.3,
        "45": 51.1,
        "50": 55.0,
        "55": 58.3,
        "60": 'Max',
        "65": 'Max',
        "70": 'Max',
        "75": 'Max',
        "80": 'Max',
        "85": 'Max',
        "90": 'Max',
        "95": 'Max',
        "100": 'Max',
    },
    "41.1": { 
        "40": 51.1,
        "45": 54.4,
        "50": 58.3,
        "55": 'Max',
        "60": 'Max',
        "65": 'Max',
        "70": 'Max',
        "75": 'Max',
        "80": 'Max',
        "85": 'Max',
        "90": 'Max',
        "95": 'Max',
        "100": 'Max',
    },
    "42.2": { 
        "40": 54.4,
        "45": 58.3,
        "50": 'Max',
        "55": 'Max',
        "60": 'Max',
        "65": 'Max',
        "70": 'Max',
        "75": 'Max',
        "80": 'Max',
        "85": 'Max',
        "90": 'Max',
        "95": 'Max',
        "100": 'Max',
    },
    "43.3": { 
        "40": 57.8,
        "45": 'Max',
        "50": 'Max',
        "55": 'Max',
        "60": 'Max',
        "65": 'Max',
        "70": 'Max',
        "75": 'Max',
        "80": 'Max',
        "85": 'Max',
        "90": 'Max',
        "95": 'Max',
        "100": 'Max',
    },
};

const tableColor = {
    '第一級' : "levelOne",
    '第二級' : "levelTwo",
    '第三級' : "levelThree",
    '第四級' : "levelFour",
};
// 2. 獲取所有可用的溫度和濕度值，並排序
const temperatureKeys = Object.keys(temperatureHumidityLookup);
// 將Key的文字轉成數值後進行小到大排列。
const availableTemperatures = temperatureKeys.map(key => parseFloat(key)).sort((a, b) => a - b);

const availableHumidities = [40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100]; // 濕度列表已經是排序好的

// 3. 寫入核心查找函式
function findLookupValue(inputTemperature, inputHumidity) {
    // --- 步驟 A: 處理溫度 ---
    let selectedTemperature;

    // 尋找最接近且大於等於的溫度 (處理邊界情況)
    // 我們需要找到一個數值，這個數值在 availableTemperatures 陣列裡
    // availableTemperatures 陣列裡的每一個數字 temp，檢查這個 temp 是不是「大於或等於」。(溫度上只能取一樣過高一階的)
    selectedTemperature = availableTemperatures.find(temp => temp >= inputTemperature);

    // 如果輸入的溫度比所有可用溫度都大，則選取最大的那個
    if (selectedTemperature === undefined && inputTemperature > availableTemperatures[availableTemperatures.length - 1]) {
        selectedTemperature = availableTemperatures[availableTemperatures.length - 1];
        console.warn(`輸入溫度 ${inputTemperature}°C 超出已知範圍，將使用最高溫度 ${selectedTemperature}°C 進行查找。`);
        // 如果輸入溫度小於最小可用溫度，也使用最小溫度
    } else if (selectedTemperature === undefined && inputTemperature < availableTemperatures[0]) {
        selectedTemperature = availableTemperatures[0];
        console.warn(`輸入溫度 ${inputTemperature}°C 低於已知範圍，將使用最低溫度 ${selectedTemperature}°C 進行查找。`);
    }

    // 如果經過處理後，selectedTemperature 依然是 undefined (不太可能，但做個檢查)
    if (selectedTemperature === undefined) {
        console.error("無法確定要使用的溫度！");
        return null;
    }

    // --- 步驟 B: 處理濕度 ---
    let selectedHumidity;

    // 尋找最接近且大於等於的濕度 (處理邊界情況)
    selectedHumidity = availableHumidities.find(hum => hum >= inputHumidity);

    // 如果輸入的濕度比所有可用濕度都大，則選取最大的那個
    if (selectedHumidity === undefined && inputHumidity > availableHumidities[availableHumidities.length - 1]) {
      selectedHumidity = availableHumidities[availableHumidities.length - 1];
      console.warn(`輸入濕度 ${inputHumidity}% 超出已知範圍，將使用最高濕度 ${selectedHumidity}% 進行查找。`);
    } else if (selectedHumidity === undefined && inputHumidity < availableHumidities[0]) {
      // 如果輸入濕度小於最小可用濕度，也使用最小濕度
      selectedHumidity = availableHumidities[0];
      console.warn(`輸入濕度 ${inputHumidity}% 低於已知範圍，將使用最低濕度 ${selectedHumidity}% 進行查找。`);
    }

     // 如果經過處理後，selectedHumidity 依然是 undefined
    if (selectedHumidity === undefined) {
        console.error("無法確定要使用的濕度！");
        return null;
    }

    // --- 步驟 C: 從對照表中查找對應值 ---
    // *** 關鍵改進在這裡 ***
    // 將選定的溫度轉換成字串，確保格式與物件的鍵一致
    // 使用 toFixed(1) 可以確保例如 30.0 變成 "30.0"，而不是 "30"
    const lookupKeyTemperature = selectedTemperature.toFixed(1);
    const lookupKeyHumidity = String(selectedHumidity); // 濕度本來就是整數，直接轉字串沒問題

    // console.log(`查找鍵: 溫度 "${lookupKeyTemperature}", 濕度 "${lookupKeyHumidity}"`);

    if (temperatureHumidityLookup[lookupKeyTemperature] && temperatureHumidityLookup[lookupKeyTemperature][lookupKeyHumidity] !== undefined) {
      return temperatureHumidityLookup[lookupKeyTemperature][lookupKeyHumidity];
    } else {
      // 如果直接查找失敗，可以再做一次備選查找，例如查找最接近的（但這會更複雜）
      // 目前這裡先記錄找不到，你可以根據需求決定是否回傳 null 或其他預設值
      console.error(`找不到溫度 ${selectedTemperature}°C (鍵: "${lookupKeyTemperature}") 和濕度 ${selectedHumidity}% (鍵: "${lookupKeyHumidity}") 的對應值。`);
      return null;
    }
}

    // 同步 氣象局API進行，資料獲取
    async function weatherForecast() {

        // 確認你要的格式是 JSON 或 XML，再替換 {fileType}
        const time = getStartAndEndOfToday(); // 或 'XML'

        const baseUrl = `https://opendata.cwa.gov.tw/api/v1/rest/datastore/F-D0047-093`;

        const params = new URLSearchParams({
            'Authorization': 'CWA-91E1B5A9-E6FB-4445-BEB2-45E1942CF0E5',
            'locationId': 'F-D0047-065,F-D0047-077',
            // CWA API 通常使用 apikey 參數
            'LocationName': '新市區,善化區,路竹區',
            'ElementName': '溫度,相對濕度',
            'timeFrom': time.startTime,
            'timeTo': time.endTime
        });

        const requestUrl = `${baseUrl}?${params.toString()}`;

        try {
            const response = await fetch(requestUrl, {
                method: 'GET', // 預設就是 GET，但寫出來更清楚
            });

            // 檢查請求是否成功 (例如：狀態碼 200)
            if (!response.ok) {
                // 如果請求失敗，拋出錯誤
                throw new Error(`HTTP 錯誤! 狀態碼: ${response.status}`);
            }

            // 解析回應，通常是 JSON 格式
            const data = await response.json();

            // 成功取得資料後，你可以在這裡處理 data
            console.log("成功取得 預測 API 資料:", data);

            return data; // 可以回傳處理後的資料

        } catch (error) {
            // 處理請求過程中發生的任何錯誤
            console.error("請求 API 時發生錯誤:", error);
            return null; // 發生錯誤時回傳 null 或其他指示
        }
    }

    async function localObservation(){

        const baseUrl = `https://opendata.cwa.gov.tw/api/v1/rest/datastore/O-A0003-001`;

        const params = new URLSearchParams({
            'Authorization': 'CWA-91E1B5A9-E6FB-4445-BEB2-45E1942CF0E5',
            // 監測站點：依序為，路竹、新市、善化
            'StationId': 'CAV270,CAN150,CAN090',
            // CWA API 通常使用 apikey 參數
            'WeatherElement': 'AirTemperature,RelativeHumidity',
        });

        const requestUrl = `${baseUrl}?${params.toString()}`;

        try {
            const response = await fetch(requestUrl, {
                method: 'GET', // 預設就是 GET，但寫出來更清楚
            });

            // 檢查請求是否成功 (例如：狀態碼 200)
            if (!response.ok) {
                // 如果請求失敗，拋出錯誤
                throw new Error(`HTTP 錯誤! 狀態碼: ${response.status}`);
            }

            // 解析回應，通常是 JSON 格式
            const data = await response.json();
            const dataArrange = localDataOrganization(data);
            // 成功取得資料後，你可以在這裡處理 data
            console.log("成功取得 觀測 API 資料:", dataArrange);

            return dataArrange; // 可以回傳處理後的資料

        } catch (error) {
            // 處理請求過程中發生的任何錯誤
            console.error("請求 API 時發生錯誤:", error);
            return null; // 發生錯誤時回傳 null 或其他指示
        }
    }


    // 自動取得今日時間，並設定需求格式
    function getStartAndEndOfToday() {
        // 1. 取得今天的日期物件
        const today = new Date();
        
        // 2. 設定開始時間 (今天的 06:00:00)
        const startTime = new Date(today); // 複製一份今天的日期
        startTime.setHours(6, 0, 0, 0); // 設定小時、分鐘、秒、毫秒
        
        // 3. 設定結束時間 (今天的 19:00:00)
        const endTime = new Date(today); // 再複製一份今天的日期
        endTime.setHours(19, 0, 0, 0); // 設定小時、分鐘、秒、毫秒
        
        // 4. 格式化成 yyyy-MM-ddThh:mm:ss 的函數
        function formatDateTime(date) {
          const year = date.getFullYear();
          // getMonth() 回傳的是 0-11，所以要 +1
          const month = String(date.getMonth() + 1).padStart(2, '0');
          const day = String(date.getDate()).padStart(2, '0');
          const hours = String(date.getHours()).padStart(2, '0');
          const minutes = String(date.getMinutes()).padStart(2, '0');
          const seconds = String(date.getSeconds()).padStart(2, '0');
        
          return `${year}-${month}-${day}T${hours}:${minutes}:${seconds}`;
        }
      
        // 5. 輸出格式化後的結果
        const formattedStartTime = formatDateTime(startTime);
        const formattedEndTime = formatDateTime(endTime);
      
        return {
          startTime: formattedStartTime,
          endTime: formattedEndTime
        };
    }
    // 導入氣象局資料，並進行整理
    function dataOrganization(location) {

        const allData = [];
        location.forEach(function(loc) {
            // 取消選擇
            const title = loc.LocationName;
            const weather = loc.WeatherElement;
            // 將資料進行整理
            const transformedResult = transformDataByTime(weather);

            // 正確的寫法：使用計算屬性名稱 []
        const locData = { [title]: transformedResult };

        allData.push(locData);
        });
        // console.log(allData);

        return allData;
    }
    // 導入氣象局資料，並進行整理
    function localDataOrganization(dataInput) {
        const station = dataInput.records.Station;

        const locData = {};
        station.forEach(function(loc) {
            // 取消選擇
            const title = loc.GeoInfo.TownName;
            const date = loc.ObsTime.DateTime;
            const timeParts =  date.split('T');
            const time = timeParts[1].substring(0, 5);
            const weather = loc.WeatherElement;
            const temperature = weather.AirTemperature;
            const humidity = weather.RelativeHumidity;
            // 熱指數
            const heat = findLookupValue(temperature, humidity);
            // 熱危害分級
            const level = determineLevel(heat);
            const outputData = {
                DataTime : time,
                Temperature : temperature,
                RelativeHumidity : humidity,
                HeatHazard : heat,
                Heatlevel : level,
            };

            // 正確的寫法：使用計算屬性名稱 []
            locData[title] =  outputData ;

        });
        // console.log(allData );

        return locData;
    }
    // 將資料轉換，依照區域 : { 溫度 & 濕度 } 進行整理
    function transformDataByTime(data) {
         const timeMap = new Map(); // 使用 Map 來儲存，key 是 DataTime

        data.forEach(elementGroup => {
            const elementName = elementGroup.ElementName;
            elementGroup.Time.forEach(timeEntry => {
                const originalTime = timeEntry.DataTime;
                const valueObj = timeEntry.ElementValue[0]; // 假設每個時間點只有一個值
                const dateTime = originalTime.substring(0, 19);

                // 如果 Map 中還沒有這個時間點，就先建立一個物件
                if (!timeMap.has(dateTime)) {
                    timeMap.set(dateTime, { DataTime: dateTime });
                }

                // 根據 ElementName 加入對應的屬性
                const currentEntry = timeMap.get(dateTime);
                if (elementName === "溫度") {
                    currentEntry.Temperature = valueObj.Temperature;
                } else if (elementName === "相對濕度") {
                    currentEntry.RelativeHumidity = valueObj.RelativeHumidity;
                }
                // 如果有其他要素，可以在這裡繼續添加 else if 條件
            });
        });

        // 將 Map 的值轉換為陣列
        const transformedArray = Array.from(timeMap.values());

        // (可選) 按照 DataTime 排序，確保順序
        transformedArray.sort((a, b) => new Date(a.DataTime) - new Date(b.DataTime));

        return transformedArray;
    }
    // 倒入氣象局資料，添加熱指數與熱危害分級
    function heatHazardIndexn(data) {
        const reData = {};
        data.forEach(input => {
            const objectKeys = Object.keys(input);
            const array = input[objectKeys];
            const outputArray =[];
            
            array.forEach((record, index) => {
                const dateTime = record.DataTime;
                const temperature = record.Temperature;
                const humidity = record.RelativeHumidity;
                // 熱指數
                const heat = findLookupValue(temperature, humidity);
                // 熱危害分級
                const level = determineLevel(heat);
                
                const outputData = {
                    DataTime : dateTime,
                    Temperature : temperature,
                    RelativeHumidity : humidity,
                    HeatHazard : heat,
                    Heatlevel : level,
                };
                outputArray.push(outputData);

            });
            reData[objectKeys] = outputArray;
            
        });

        return reData;
    }
    // 熱危害指數分級
    function determineLevel(value) {
        // 首先處理特殊字串 "Max"
        if (typeof value === 'string' && value.toLowerCase() === 'Max') {
          return "第四級";
        }
      
        // 將輸入值轉換為數字，如果轉換失敗則回傳錯誤訊息
        const numValue = parseFloat(value);
      
        if (isNaN(numValue)) {
          console.error("輸入的數值無效，無法判斷級別。");
          return "無效輸入"; // 或者您可以選擇拋出錯誤
        }
      
        // 按照您定義的條件進行判斷
        if (numValue < 26.7) {
          return "第零級";
        } else if (numValue < 32.2) { // 這裡的 numValue 必然 >= 26.7
          return "第一級";
        } else if (numValue < 40.6) { // 這裡的 numValue 必然 >= 32.2
          return "第二級";
        } else if (numValue < 54.4) { // 這裡的 numValue 必然 >= 40.6
          return "第三級";
        } else { // numValue >= 54.4
          return "第四級";
        }
    }

    // 頁數相關
function pageBarCount(jsonData, baseData, string) {
    // console.log(jsonData);
    // const showData = JSON.parse(jsonData);
    // 2. 设置每页显示的记录数
    const allPage = 100;
    // 3. 计算总页数
    const allPages = Math.ceil(jsonData.length / allPage);
    // 4. 显示第一页数据
    let currentPage = 1;
    renderTableContent(currentPage, allPage, jsonData, baseData, string);
    renderPagination(currentPage, allPage, allPages, jsonData, baseData, string);
}


// 針對表格
function renderTableContent(page, allPage, jsonData, baseData, string) {

    // 清除现有的内容
    const heatRow = $(`#heatRow`);

    heatRow.empty();
    // 计算起始和结束索引
    const startIndex = (page - 1) * allPage;
    const endIndex = Math.min(startIndex + allPage, jsonData.length);
    let day = '';
    let tableHtml = '';
    
    // console.log(endIndex);
    if(jsonData.length !=0){

        Object.entries(jsonData).forEach(function( [key, data]) {

            let tbodyInput = '';
            data.forEach(row => {
                const timeParts = row.DataTime.split('T');
                const time = timeParts[1].substring(0, 5);
                let color = '';
                day = timeParts[0];
                if(row['Heatlevel'] == "第一級"){
                    color = "color:rgb(0, 228, 128);";
                }else if(row['Heatlevel'] == "第二級"){
                    color = "color:rgb(230, 180, 70)";
                }else if(row['Heatlevel'] == "第三級"){
                    color = "color:rgb(255, 165, 0);";
                }else if(row['Heatlevel'] == "第四級"){
                    color = "color:rgb(238, 76, 30);font-weight: bold;";
                }

                let bodyInside = `
                    <tr>
                        <td >預測</td>
                        <td >${time}</td>
                        <td >${row['Temperature']}°C</td>
                        <td >${row['RelativeHumidity']}%</td>
                        <td style="${color}">${row['HeatHazard']}</td>
                        <td style="${color}">${row['Heatlevel']}</td>
                    </tr>
                    `;
                tbodyInput += bodyInside;
            });
            const heatLevel = baseData[key]['Heatlevel'];
            tableHtml = `
                <div class="col-6">
                    <table class="table table-light table-striped table-hover table-sm align-middle" style='text-align: center;'>
                        <thead>
                            <tr>
                                <th colspan="6" style="font-weight: bold;">${key}</th>
                            </tr>
                            <tr>
                                <th style="">類別</th>
                                <th style="">時間</th>
                                <th style="">溫度</th>
                                <th style="">相對溼度</th>
                                <th style="">熱指數</th>
                                <th style="">熱危害風險等級</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="${tableColor[heatLevel]}" >
                                <td>觀測</td>
                                <td>${baseData[key]['DataTime']}</td>
                                <td>${baseData[key]['Temperature']}°C</td>
                                <td>${baseData[key]['RelativeHumidity']}%</td>
                                <td>${baseData[key]['HeatHazard']}</td>
                                <td>${heatLevel}</td>
                            </tr>
                            ${tbodyInput}
                        </tbody>
                    </table>
                </div>
            `;
            const newRow = $(tableHtml);
            heatRow.append(newRow);
            
        })

        const timeMark = document.getElementById(`heatMark`);
        timeMark.innerText = `資料日為：${day}`;
    }else{
        tableHtml = `
            <div class="col-12">
                <table class="table table-light table-striped table-hover table-sm align-middle" style='text-align: center;'>
                    <thead>
                        <tr>
                            <th style="">時間</th>
                            <th style="">溫度</th>
                            <th style="">相對溼度</th>
                            <th style="">熱指數</th>
                            <th style="">熱危害風險等級</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" style="font-weight: bold;">${key}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;
        const newRow = $(tableHtml);
        heatRow.append(newRow);
    }

    
}

// 針對頁數
function renderPagination(page, allPage, allPages, jsonData, baseData, string) {
    const stringChang = string.replace(/\(/g, '\\(').replace(/\)/g, '\\)');
    // 設定變數
    // 控制哪個頁
    const allNum = $(`#${stringChang}_Num`);
    // 控制該頁按鈕
    const allBtn = $(`#${stringChang}_Btn`);
    // 頁碼按鈕
    const startIndex = (page - 1) * allPage;

    const endIndex = Math.min(startIndex + allPage, jsonData.length);
    //  “short-circuit evaluation”（短路評估）
    // 範例 A || B ，當A不等於false(aka 0, '', null, undefined 和 NaN)，則回傳A本身，否則回傳B。
    allPages = allPages || 1;
    // 更新分页文本显示
    allNum.html(`顯示 ${startIndex + 1} 到 ${endIndex} 筆 共 ${jsonData.length} 筆，目前在第 ${page} 頁 共 ${allPages} 頁`);
    // 清除现有分页按钮
    allBtn.empty();
    // 检查是否只有一页或没有数据
    const isSinglePage = allPages <= 1;
    // 添加 "第一页" 按钮
    // 以下邏輯雷同
    const firstPageBtn = $(`<li class="page-item">`)
        // 增加clss元素，disable，在page == 1，或是 沒數據。
        .toggleClass('disabled', page === 1 || isSinglePage)
        // 補上其他元素。
        .append(
            $(`<a class="page-link" href="#" aria-label="First"><i class="bi bi-chevron-bar-left"></i></a>`)
        )
        // 點擊時觸發
        .click(function () {
            if (page !== 1) {
                page = 1;
                renderTableContent(page, allPage, jsonData, baseData, string);
                renderPagination(page, allPage, allPages, jsonData, baseData, string);
            }
        });
    // 添加 "上一页" 按钮
    const prevPageBtn = $(`<li class="page-item"></li>`)
        .toggleClass('disabled', page === 1 || isSinglePage)
        .append(
            $(`<a class="page-link" href="#" aria-label="Previous"><i class="bi bi-chevron-double-left"></i></a>`)
        )
        .click(function () {
            if (page > 1) {
                page -= 1;
                renderTableContent(page, allPage, jsonData, baseData, string);
                renderPagination(page, allPage, allPages, jsonData, baseData, string);
            }
        });
    allBtn.append(firstPageBtn, prevPageBtn);

    // 計算頁碼顯示範圍
    let startPage = Math.max(1, page - 4);
    let endPage = Math.min(allPages, page + 4);

    // 加入前置 "..." 標籤，小於page-4
    if (startPage > 1) {
        const ellipsisStart = $(`<li class="page-item"><a class="page-link" id="${string}Btn_${startPage - 1}"><i class="fa-solid fa-ellipsis"></i></a></li>`)
                .click(function () {
                    page = startPage - 1;
                    renderTableContent(page, allPage, jsonData, baseData, string);
                    renderPagination(page, allPage, allPages, jsonData, baseData, string);
                });
        allBtn.append(ellipsisStart);
    }

    // 添加頁碼按鈕
    for (let i = startPage; i <= endPage; i++) {
        const pageBtn = $(`<li class="page-item"></li>`)
            .toggleClass('active', i === page)
            .append(
                $(`<a class="page-link" id="${string}Btn_${i}" href="#">${i}</a>`)
            )
            .click(function () {
                page = i;
                renderTableContent(page, allPage, jsonData, baseData, string);
                renderPagination(page, allPage, allPages, jsonData, baseData, string);
            });

        allBtn.append(pageBtn);
    }

    // 加入後置 "..." 標籤，大於page+4
    if (endPage < allPages) {
        const ellipsisEnd = $(`<li class="page-item"><a class="page-link" id="${string}Btn_${endPage + 1}"><i class="fa-solid fa-ellipsis"></i></a></li>`)
                .click(function () {
                    page = endPage + 1;
                    renderTableContent(page, allPage, jsonData, baseData, string);
                    renderPagination(page, allPage, allPages, jsonData, baseData, string);
                });
        allBtn.append(ellipsisEnd);
    }
    // 添加 "下一页" 按钮
    const nextPageBtn = $(`<li class="page-item"></li>`)
        .toggleClass('disabled', page === allPages || isSinglePage)
        .append(
            $(`<a class="page-link" href="#" aria-label="Next"><i class="bi bi-chevron-double-right"></i></a>`)
        )
        .click(function () {
            if (page < allPages) {
                page += 1;
                renderTableContent(page, allPage, jsonData, baseData, string);
                renderPagination(page, allPage, allPages, jsonData, baseData, string);
            }
        });
    // 添加 "最后一页" 按钮
    const lastPageBtn = $(`<li class="page-item"></li>`)
        .toggleClass('disabled', page === allPages || isSinglePage)
        .append(
            $(`<a class="page-link" href="#" aria-label="Last"><i class="bi bi-chevron-bar-right"></i></a>`)
        )
        .click(function () {
            if (page !== allPages) {
                page = allPages;
                renderTableContent(page, allPage, jsonData, baseData, string);
                renderPagination(page, allPage, allPages, jsonData, baseData, string);
            }
        });
    allBtn.append(nextPageBtn, lastPageBtn);
}
// 繪圖前的資料整理
function drawingHeatIndexData(jsonData){
    const transformedData = {}; // 這是我們要輸出的新物件
    let today = '';
    const heatHazardGroup = {};

    // 遍歷 JSON 中的每個地區 (例如: "路竹區", "善化區")
    for (const region in jsonData) {
        if (jsonData.hasOwnProperty(region)) {
            const regionData = jsonData[region]; // 取得該地區的所有時間點資料
            const heatHazardArray = [];
            // 遍歷該地區下每個時間點的資料
            regionData.forEach(item => {
                const dateTime = item.DataTime; // 取出 DataTime 作為第一層 Key
                const temperature = item.Temperature;
                const relativeHumidity = item.RelativeHumidity;
                const heatHazard = item.HeatHazard;
                const heatLevel = item.Heatlevel;
                heatHazardArray.push(heatHazard);
                // 如果 transformedData 裡還沒有這個 dateTime，就建立一個新的物件
                if (!transformedData[dateTime]) {
                    transformedData[dateTime] = {};
                }
                if (today == '') {
                    today = dateTime.substring(0, 10);
                    // transformedData[dateTime] = {};
                }
                // 在該 dateTime 下，以地區名稱作為 Key，並存入相關的氣象資訊
                transformedData[dateTime][region] = {
                    'Temperature': temperature,
                    'RelativeHumidity': relativeHumidity,
                    'HeatHazard': heatHazard,
                    'Heatlevel': heatLevel
                };
            });
            heatHazardGroup[region] = heatHazardArray;
        }
    }
    const reData = {
        'time'  : transformedData,
        'today' : today,
        'heatHazard' : heatHazardGroup,
    };
        

  return reData;
}
// 繪圖指令
function drawingHeatIndexChart(drawChart){
    const timeChart = drawChart['time'];
    const heatChart = drawChart['heatHazard'];
    const timeKeysArray = []; // 先建立一個空陣列

    // 遍歷物件的 Keys
    for (const key in timeChart) {
      // 確保是物件本身的屬性，而不是繼承來的
      if (timeChart.hasOwnProperty(key)) {
            const timeParts = key.split('T');
            const time = timeParts[1].substring(0, 5);
        timeKeysArray.push(time); // 將 Key 加入陣列
      }
    }
    // console.log(timeKeysArray);
    const seriesData = [];
    let intoLine = false;
    Object.entries(heatChart).forEach(function( [key, heat]) {
        //         const heatLine = 54.4;
        //         const markPoints = [];
        //         heat.forEach((item, index) => {
        //             console.log(item);
        //             if (item > heatLine) {
        //                 markPoints.push({
        //                     name: `Peak`, // 自定義名稱，例如加上 "Peak"
        //             value: item,
        //             xAxis: index, // 假設 xAxis 是數據的索引
        //             yAxis: item,

        //             symbol: 'circle', // 圖標形狀 (也可以是 'rect', 'roundRect', 'triangle', 'diamond')
        //             label: {},
        // symbolSize: '',
        // itemStyle: {               // 來自 ECharts 的預設 itemStyle 設定
        //          color: '', // 來自系列的主色調

        //     }

        //                 });
        //             }
        //         });



        let heatData = {
            name: key,
            type: 'line',
            data: heat,
            markPoint: {
                data: [{ type: 'max', name: 'Max Value' }],
                // 標記點大小，可以自行調整
                // symbolSize: 20, 
                // label: {
                //   formatter: '{b}: {c}' // 顯示名稱和數值
                // },
                // symbolOffset: [0, -10] 
                // 設置垂直位移，[水平位移, 垂直位移] (單位是像素)
            },
            
        };
        // console.log(markPoints);
        // 如果為 false(警示線 一條就好)
        // 補上警示線，並將數據轉為OK
        if(!intoLine){
            intoLine = true;
            heatData['markLine'] = {
              data: [
                    // --- 新增的高標線 ---
                    {
                      name: 'High Target', // 標示線的名稱
                      yAxis: 54.4,           // 設定 y 軸的數值為 17
                      lineStyle: {
                        color: 'red',      // 可以設定顏色，例如紅色
                        type: 'dashed'     // 可以設定線條樣式，例如虛線
                      },
                      label: {
                        position: 'middle', // 標籤顯示在線條中間
                        formatter: '54.4_四級 極度危險' // 標籤文字
                      }
                    }
                    // --- 新增結束 ---
                ]
            }
        }
        if(key == '善化區'){
            heatData['markPoint']['symbolOffset'] = [0, -10];
        }
        // console.log(heatData);
        seriesData.push(heatData);

    })

    var dom = document.getElementById('container');
    var myChart = echarts.init(dom, null, {
        renderer: 'canvas',
        useDirtyRect: false
    });
    // var app = {};

    var option;

    option = {
        title: {
            text: 'Heat Index Chart(預測)'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {},
        toolbox: {
            show: true,
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: { readOnly: false },
                magicType: { type: ['line', 'bar'] },
                restore: {},
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: timeKeysArray,
        },
        yAxis: {
            type: 'value',
            min: 25,
            max: 60,
            axisLabel: {
                formatter: '{value} '
            }
        },
            
        series: seriesData,
        // series: [
        //   {
        //     name: 'Highest',
        //     type: 'line',
        //     data: [10, 11, 13, 11, 12, 12, 9],
        //     markPoint: {
        //       data: [
        //         { type: 'max', name: 'Max' },
        //         { type: 'min', name: 'Min' }
        //       ]
        //     },
        //     markLine: {
        //       data: [{ type: 'average', name: 'Avg' }]
        //     }
        //   },
        //   {
        //     name: 'Lowest',
        //     type: 'line',
        //     data: [1, -2, 2, 5, 3, 2, 0],
        //     markPoint: {
        //       data: [{ name: '周最低', value: -2, xAxis: 1, yAxis: -1.5 }]
        //     },
        //     markLine: {
        //       data: [
        //         { type: 'average', name: 'Avg' },
        //         [
        //           {
        //             symbol: 'none',
        //             x: '90%',
        //             yAxis: 'max'
        //           },
        //           {
        //             symbol: 'circle',
        //             label: {
        //               position: 'start',
        //               formatter: 'Max'
        //             },
        //             type: 'max',
        //             name: '最高点'
        //           }
        //         ]
        //       ]
        //     }
        //   }
        // ]
    };
// console.log(option);
    if (option && typeof option === 'object') {
        myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
}

function sendHeadAlert(heatJson, drawData, localHeat){
    console.log(heatJson);
    console.log(drawData);
    console.log(localHeat);
    // 主要參數設定區
    // 設定抓取需要HightLine的等級。
    const alertArray = {
        '第一級' : 1,
        '第二級' : 2,
        '第三級' : 3,
        '第四級' : 4,
    }

    // 設定是否需要發MAPP
    let sendFirst = false;
    let sendSecond = false;

    const heatDate = heatJson['date'];
    let heatPredict = heatJson['predictCheck'];
    const heatFirst = heatJson['first'];
    let checkFirst = heatFirst['check'];
    const heatSecond = heatJson['second'];
    let checkSecond = heatSecond['check'];
    // 先處理，暫存資料區的資料是否更新。
    // 檢查背景資料，的時間記號，是否與今天一致。
    const allDayHeatCheck = (heatDate == drawData['today'])?  false: true;
    // 如果時間不一致，則進入確認環節
    const sendHeatCheck = (allDayHeatCheck)?  'Check':
                        // 如果今天尚未發報，則進入確認環節；反之則關閉
                        ((heatPredict == 'On')? 'Check': 'unCheck');

    // 先處理預估資料
    // 取出時間序列資料。
    const dateTime = drawData['time'];
    let predictData = {};
    let maybeLocal = [];
    // console.log(drawData);
    Object.entries(dateTime).forEach(function( [keyT, area]) {
        // 將時間進行拆分。
        const timeParts =  keyT.split('T');
        // 取出"時間"。
        const time = timeParts[1].substring(0, 5);
        // let alertPredict  = '預測：'

        // 將同一時間，三個區域的資料繞開
        Object.entries(area).forEach(function( [locKey, temp]) {
            const heatlevel = temp['Heatlevel'];
            if(predictData[locKey] == null){

                predictData[locKey] = [];
            }

            const heatScore = alertArray[heatlevel];
            // 確認危害等級是否為關注的
            if( heatScore > 1){
                // 關注的危害等級則進行儲存。
                predictData[locKey].push(time);
                if(!maybeLocal.includes(locKey)){
                    maybeLocal.push(locKey);
                }
            }
        })
    })

    // 設定是否進到發報程序
    // 預設為停止
    let todayHeatCheck = 'Stop';
    // 如果 需要送出 為開啟，表示本日尚未檢查。
    if(sendHeatCheck == 'Check'){
        // 如果預估值裡面有大於目標的。則續GO，反之則停止
        todayHeatCheck = (predictData != {})? 'Go': 'Stop';
    }
    // 強迫測試用
    // todayHeatCheck = 'Go';
    console.log(todayHeatCheck);
    // 處理後續警報
    // 建立警告字串
    let warningString = '【熱危害警報通知】';
    let stringFirst = '';
    let stringSecond  = '';
    let warningFirst = false;
    let warningSecond = false;
    if(todayHeatCheck != 'Stop'){

        // 繞開原始資料
        Object.entries(localHeat).forEach(function( [locKey, heat]) {
            const time = heat['DataTime'];
            const heatlevel = heat['Heatlevel'];
            const heatScore = alertArray[heatlevel];

            // console.log(key);
            // 測試用
            // if( heatScore > 0 && heatScore < 4 ){
            if( heatScore > 1 && heatScore < 4 ){
                if(stringFirst == ''){
                    stringFirst = `${warningString}_${time} 監測記錄：\n`;
                }
                stringFirst += `目前【${locKey}】地區：溫度【${heat['Temperature']}℃】；濕度【${heat['RelativeHumidity']}％】。熱危害等級已到達【${heat['Heatlevel']}】。\n`;
                warningFirst = true;
            }
            if( heatScore == 4 ){
                if(stringSecond == ''){
                    stringSecond = `${warningString}_${time} 監測記錄：\n`;
                }
                stringSecond += `目前【${locKey}】地區：溫度【${heat['Temperature']}℃】；濕度【${heat['RelativeHumidity']}％】。熱危害等級已到達【${heat['Heatlevel']}】。\n`;
                warningSecond = true;
            }
        })

        if(warningFirst){
            // const maybeString = maybeLocal.map(item => `"${item}"`).join("、");
            // stringFirst += `本日預測值，${maybeString}，有達【第二級】以上的時段。\n`;
            stringFirst += `提醒廠區熱危害等級已到達【第二級】者，需留意戶外作業之承攬商是否確實依照台灣廠區高、低氣溫戶外作業危害防範措施檢核表內容執行檢核。`;
            sendFirst = (checkFirst == 'On')? true : false;
        }
        if(warningSecond){
            stringSecond += `熱危害等級已到達【第四級】。需留意戶外作業之承攬商是否設置遮陽設施，並提供風扇、水霧或其他具降低作業環境溫度效果之設備。`;
            sendSecond = (checkSecond == 'On')? true : false;
        }
        // 看是否要傳到MAPP
        if(sendFirst ){
            // sendChatMessage(stringFirst, '', 1);
            checkFirst = 'Off';
        }
        if(warningSecond ){
            // sendChatMessage(stringSecond, '', 1);
            checkSecond = 'Off';
        }  
    }else{
        heatPredict = 'Off';
    }
    const firstData = {
        'check' : checkFirst,
        'send' : stringFirst,
    };

    const secondData = {
        'check' : checkSecond,
        'send' : stringSecond,
    };
// console.log(firstData);
// console.log(secondData);
    saveHeatLogJson(drawData['today'], heatPredict, firstData, secondData);
};
// MAPP
// mapp參數設定
const apt = {
    'msg' : {
        'URL'       :   "IMService.ashx",
        'ASK'       :    {
                            "all" : "sendChatMessage",
                            "to"  : "sendChatMessage",
                            "uf"  : "uploadFile"
                        },
        // 'ACCOUNT'   :   'API_TEST',
        // 'API_KEY'   :   'BC59A77F-2697-0125-0B0A-DBBB7A89A7D6',
        // 'CHAT_SN'   :   '127059'
    
        // 正式
            'ACCOUNT' : 'api_catapush',
            'API_KEY' : 'F8E67FCB-DA94-0F1C-1EA9-D7B319627DF5',
            'CHAT_SN' : '8643'
            // 'CHAT_SN' : '375487'
    },

}
// 非同步 函式：該函式為"交談室"的"訊息"(檔案或文字)傳送
// kind參數
// 1: 文字
// 2: 檔案（ 圖片、影片、聲音以及文件)
// FILE_SHOW_NAME
// 如為Kind == 2 時，成立。

    async function sendChatMessage(fileCode, fileName, kind){
        try {
                // 建立"Headers()"
                const myHeaders = new Headers();
                myHeaders.append("Content-Type"   , "application/x-www-form-urlencoded" );
                // "交談室"格式請參考式樣書
                const urlencoded = new URLSearchParams();
                urlencoded.append("ACCOUNT"         , apt.msg.ACCOUNT );
                urlencoded.append("API_KEY"         , apt.msg.API_KEY );
                urlencoded.append("CHAT_SN"         , apt.msg.CHAT_SN );
                urlencoded.append("CONTENT_TYPE"    , kind );
                urlencoded.append("MSG_CONTENT"     , fileCode );
                urlencoded.append("FILE_SHOW_NAME"  , fileName );
                urlencoded.append("parm"            , `{"kind":"chatRoom","who":"all"}`);
                // MAPP的API導入格式
                const requestOptions = {
                      method   : "POST",
                      headers  : myHeaders,
                      body     : urlencoded,
                      redirect : "follow"
                };
                const askName = apt.msg.ASK.all;
                const urlNet = 'https://mappapitest.innolux.com/teamplus_innolux/API/'+ apt.msg.URL +'?ask='+ askName;
                const inputArray = {
                    "URL"               : urlNet,
                    "ACCOUNT"           : apt.msg.ACCOUNT,
                    "API_KEY"           : apt.msg.API_KEY,
                    "CHAT_SN"           : apt.msg.CHAT_SN,
                    "CONTENT_TYPE"      : kind,
                    "MSG_CONTENT"       : fileCode,
                    "FILE_SHOW_NAME"    : fileName,
                };

                // 发起请求并返回结果，參數1為"跳板API網頁"；參數2為"輸入資料"。
                const response = await fetch("http://tneship.cminl.oa/api/proxy/mapp.php", requestOptions);
                const result = await response.text();
                var jsonString = JSON.stringify(inputArray);
                const outputData = {
                    'input'     : jsonString,
                    'apiBack'   :result,
                };
                // console.log(result);
                return outputData;

            } catch (error) {
                console.error("消息发送失败:", error);
                throw error; // 抛出错误供调用者处理
            }
    }

    async function saveHeatLogJson(date, predict, first, second){
    // console.log(saveData);
        const jsonDataToSend = {
            tableName       : 'heatTemper',
            'date'          : date,
            'predictCheck'  : predict,
            'first'         : first,
            'second'        : second,
        };
        try {
            
            // 使用 Fetch API 傳送資料到 PHP
            const response = await fetch('saveTemper.php', { // 這是你的 PHP 檔案名稱
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(jsonDataToSend), // 將 JS 物件轉換成 JSON 字串傳送
            })
            const data = await response.json(); // 等待 JSON 解析
            if (data.success) {
                console.log('已成功儲存！');
            } else {
                alert('儲存失敗: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('傳送資料時發生錯誤。');
        }
    }

    // 新增一個判斷時間是否在區間內的輔助函式
    function isWithinWorkingHours() {
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const currentTime = hours * 100 + minutes; // 將時間轉為 HHmm 格式 (例如 09:30 -> 930)

        // 判斷 09:00 (900) 到 18:30 (1830)
        return currentTime >= 930 && currentTime <= 1830;
    }