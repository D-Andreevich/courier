<div style="display: none">
    <div id="info-content">
        <table>
            <tr id="iw-url-row" class="iw_table_row">
                <td id="iw-icon" class="iw_table_icon">
                    <img class="hotelIcon"
                         src="https://lh3.googleusercontent.com/6a0yWwDMUKU-qfTwYUUANsRkiArCei25vob9O2CeLdYyKKtoZ7eh73QpJecSrv76tw=w128"/>
                </td>
                <td id="iw-url"></td>
            </tr>
            <tr id="iw-address-row" class="iw_table_row">
                <td class="iw_attribute_name">Адрес:</td>
                <td id="iw-address"></td>
            </tr>
            <tr id="iw-address-row" class="iw_table_row">
                <td class="iw_attribute_name">Габариты:</td>
                <td id="iw-size"></td>
            </tr>
            <tr id="iw-address-row" class="iw_table_row">
                <td class="iw_attribute_name">Масса:</td>
                <td id="iw-weight"></td>
            </tr>
            <tr id="iw-phone-row" class="iw_table_row">
                <td class="iw_attribute_name">Дистанция:</td>
                <td id="iw-distance"></td>
            </tr>
            <tr id="iw-rating-row" class="iw_table_row">
                <td class="iw_attribute_name">Стоимость:</td>
                <td id="iw-price"></td>
            </tr>
            <tr id="iw-website-row" class="iw_table_row">
                <td class="iw_attribute_name">Deadline:</td>
                <td id="iw-deadline"></td>
            </tr>
        </table>

        @if (!Auth::guest())
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div id="courier_id" class="hidden">{{ Auth::User()->id }}</div>
            <button id="order_id" data-id="order_id_set" data-user_id="user_id_set" class="acceptedBtn  btn btn-success"
                    type="submit">Принять заказ
            </button>
            <button id="remove_order" data-id="order_id_set" class="removeBtn btn btn-danger"
                    type="submit">Отменить заказ
            </button>
            @else
            <br>
            <span class="text-center"><b>Авторизуйтесь для принятия или удаления заказа</b></span>
        @endif
    </div>
</div>
<div id="map"></div>

{{-- стилизация нужна, подумать горизонтальная/вертикальна --}}
<input type="range" id="slider" min="0.5" max="25" step="0.5" value="0.5">

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQGiP-8aFcyPivJHoP1NIi2VKYd4I8BLQ&libraries=places&callback=initMap"
        async defer></script>