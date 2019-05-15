<div class="form-group">
    <select id="s_province" name="province" class="form-control">
{{--        @if (!empty($data['province']))--}}
{{--            <option value="{{ $data['province'] }}">{{ $data['province'] }}</option>--}}
{{--        @endif--}}
        <option value="">请选择省份</option>
    </select>
    <select id="s_city" name="city" class="form-control">
{{--        @if (!empty($data['city']))--}}
{{--            <option value="{{ $data['city'] }}">{{ $data['city'] }}</option>--}}
{{--        @endif--}}
        <option value="">请选择城市</option>
    </select>
    <select id="s_county" name="area" class="form-control">
{{--        @if (!empty($data['area']))--}}
{{--            <option value="{{ $data['area'] }}">{{ $data['area'] }}</option>--}}
{{--        @endif--}}
        <option value="">请选择区县</option>
    </select>
</div>
{{--<span class="s_name"> 省</span>--}}
{{--<span class="s_name"> 市</span>--}}
{{--<span class="s_name"> 县/区</span>--}}
<script src="{{ skinPath() }}js/plugins/provinceJson/province.json"></script>
<script type="text/javascript">
    let $province = $('#s_province'),
        $city = $('#s_city'),
        $county = $('#s_county'),
        allData = [],
        provinceData = [],
        cityData = [],
        countyData = [],
        province = '',
        city = '',
        county = '';
    $.getJSON('{{ skinPath() }}js/plugins/provinceJson/province.json', (res) => {
        allData = res;
        let html = $province.html();
        for (let i in res) {
            html += '<option value="'+res[i].name+'">'+res[i].name+'</option>';
        }
        $province.html(html);
        @if (!empty($data['province']))
            makeCitySelect('{{ $data['province'] }}');
            $province.val('{{ $data['province'] }}');
        @endif
        @if (!empty($data['city']))
            makeCountySelect('{{ $data['city'] }}');
            $city.val('{{ $data['city'] }}');
        @endif
        @if (!empty($data['area']))
            $county.val('{{ $data['area'] }}');
        @endif
    });

    $province.change(() => {
        console.log('province change', $province.find('option:selected').val());
        province = $province.find('option:selected').val();
        makeCitySelect(province);
    });
    $city.change(() => {
        console.log('$city change', $city.find('option:selected').val());
        city = $city.find('option:selected').val();
        makeCountySelect(city);
    });
    $county.change(() => {
        console.log('$county change', $county.find('option:selected').val());
    });
    function makeCitySelect(p) {
        province = p;
        let html = '<option value="">请选择城市</option>';

        for (let i in allData) {
            if (province === allData[i].name) {
                let cityData = allData[i].city;
                for (let ii in cityData) {
                    html += '<option value="'+cityData[ii].name+'">'+cityData[ii].name+'</option>';
                }
                break;
            }
        }
        $city.html(html);
    }
    function makeCountySelect(c) {
        city = c;
        let html = '<option value="">请选择区县</option>';
        // 省
        for (let i in allData) {

            if (province === allData[i].name) {
                let cityData = allData[i].city;
                // 市
                for (let ii in cityData) {
                    if (city === cityData[ii].name) {
                        let countyData = cityData[ii].area;
                        // 区
                        for (let iii in countyData) {
                            html += '<option value="'+countyData[iii]+'">'+countyData[iii]+'</option>';
                        }

                    }
                }
                break;
            }
        }
        $county.html(html);
    }
</script>
