<div style="padding: 10px 20px; width: 100%; height: 100%; background: rgba(248, 248, 248, 1)">

    <div style="font-size: 18px; font-weight: 300; font-family: Helvetica, Arial, sans-serif; padding: 10px 20px; margin-bottom: 20px">
        {{$mail['text']}}
    </div>

    <div style="width:250px; margin: auto; background: rgba(45, 8, 44, 1); color: rgba(248, 248, 248, 1); padding: 10px;">
        <h3 style="font-size: 20px; font-weight: 300; font-family: Helvetica, Arial, sans-serif;">Код верификации:</h3>
        <p>{{$mail['code']}}</p>
    </div>

    <a style="width: 250px; margin: auto; background: rgba(45, 8, 44, 1); color: rgba(248, 248, 248, 1); padding: 10px;"
       href="{{$mail['url']}}"
    >
        перейти на сайт
    </a>

</div>
