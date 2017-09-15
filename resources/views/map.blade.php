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
            <tr id="iw-website-row" class="iw_table_row hidden">
                <td class="iw_attribute_name">UserId</td>
                <td id="iw-user_id"></td>
            </tr>
        </table>

        @if (!Auth::guest())
            <div id="courierId" class="hidden">{{ Auth::User()->id }}</div>
            <button id="order_id" data-id="order_id_set" data-userid="user_id_set" class="acceptedBtn changeStatusBtn btn btn-success"
                    type="submit">Принять заказ
            </button>
        @endif
    </div>
</div>

<div id="map"></div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfe_GhU5m1WWaZFqTwaqKsjs1r_Kt06_k&callback=initMap"
        async defer></script>