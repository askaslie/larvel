@layout('elements.main')
@section('content')
<h3>Тест</h3>
<p>Последние ID: <code>9375938475983</code>, <code>9428374928374</code>, <code>64736487382</code>.</p>

<form class="form-inline">
    <input type="text" class="span3" placeholder="Введите ID">
    <button type="submit" class="btn">Искать</button>
    <p class="hide">Такого ID нет в базе данных.</p>
</form>

<pre>
        {
          "api_version":"1.3",
          "response_code":"200",
          "id":"5770765303551309",
          "lon":"53.206705136404",
          "lat":"56.850740825518",
          "name":"Музейно-выставочный комплекс стрелкового оружия им. М.Т. Калашникова",
          "firm_group":{
            "id":"5770773893484797",
            "count":"1"
          },
          "register_bc_url":"http://stat.api.2gis.ru/?v=1.3&hash=A4c74H150C48e13cde540G3G6f60986584824h8898CG13G404AH1H6f",
          "review_register_bc_url":"http://stat.api.2gis.ru/?v=1.3&hash=54974H150496eeAc4e540G40bf50986582577h8898CG1J0J6339G2G5c",
          "address_click_bc_url":"http://stat.api.2gis.ru/?v=1.3&hash=f4574H150496e08c9e540G43dff098658257eh8898CG1J0J6339G2G5d",
          "city_name":"Ижевск",
          "city_id":"5770859792826371",
          "address":"Бородина,
           19",
          "create_time":"2011-01-19 12:41:07 06",
          "modification_time":"2013-02-12 20:21:37 07",
          "contacts":[
            {
              "name":"",
              "contacts":[
                {
                  "type":"fax",
                  "value":"(3412) 51-45-38"
                },
                {
                  "type":"fax",
                  "value":"(3412) 51-34-52"
                },
                {
                  "type":"email",
                  "value":"museum-mtk@mail.ru",
                  "register_bc_url":"http://stat.api.2gis.ru/?v=1.3&hash=h4974H150C48ebhcbe540GBG5f80986584827h8898CG13G404AH1H5b"
                },
                {
                  "type":"website",
                  "value":"http://link.2gis.ru/5A7F96E0/webapi/20130201/project41/5770765303551309/h4374H150C48eaBcde540G7G7fe098658482fh8898CG13G404AH1H54?http://www.museum-mtk.ru",
                  "alias":"www.museum-mtk.ru"
                }
              ]
            }
          ],
          "schedule":{
            "Tue":{
              "working_hours-0":{
                "from":"11:00",
                "to":"19:00"
              }
            },
            "Wed":{
              "working_hours-0":{
                "from":"11:00",
                "to":"19:00"
              }
            },
            "Thu":{
              "working_hours-0":{
                "from":"11:00",
                "to":"19:00"
              }
            },
            "Fri":{
              "working_hours-0":{
                "from":"11:00",
                "to":"19:00"
              }
            },
            "Sat":{
              "working_hours-0":{
                "from":"11:00",
                "to":"19:00"
              }
            },
            "Sun":{
              "working_hours-0":{
                "from":"11:00",
                "to":"19:00"
              }
            }
          },
          "payoptions":[
            "Cash",
            "Non-cash"
          ],
          "rubrics":[
            "Музеи"
          ]
        }
      </pre>

<br><br>

@endsection
