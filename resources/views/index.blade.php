<!DOCTYPE html>
<html>

<head>
    <title>Address Registration</title>
</head>

<body>
    <h2>Register Address</h2>

    <form method="POST" action="/index">
        @csrf

        <!-- Lựa chọn quốc gia -->
        <div>
            <label>Country:</label>
            <select name="country" onchange="this.form.submit()">
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}"
                        {{ (old('country') ?? $selectedCountry) == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Lựa chọn thành phố nếu đã chọn quốc gia -->
        @if (!empty($cities))
            <div>
                <label>City:</label>
                <select name="city" onchange="this.form.submit()">
                    <option value="">Select City</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}"
                            {{ (old('city') ?? $selectedCity) == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Lựa chọn quận/huyện nếu đã chọn thành phố -->
        @if (!empty($districts))
            <div>
                <label>District:</label>
                <select name="district" onchange="this.form.submit()">
                    <option value="">Select District</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}"
                            {{ (old('district') ?? $selectedDistrict) == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Lựa chọn phường/xã nếu đã chọn quận/huyện -->
        @if (!empty($wards))
            <div>
                <label>Ward:</label>
                <select name="ward" onchange="this.form.submit()">
                    <option value="">Select Ward</option>
                    @foreach ($wards as $ward)
                        <option value="{{ $ward->id }}"
                            {{ (old('ward') ?? $selectedWard) == $ward->id ? 'selected' : '' }}>
                            {{ $ward->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Lựa chọn đường nếu đã chọn phường/xã -->
        @if (!empty($streets))
            <div>
                <label>Street:</label>
                <select name="street">
                    <option value="">Select Street</option>
                    @foreach ($streets as $street)
                        <option value="{{ $street->id }}"
                            {{ (old('street') ?? $selectedStreet) == $street->id ? 'selected' : '' }}>
                            {{ $street->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Nút submit cuối cùng để lưu địa chỉ đã chọn -->
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>

    <!-- Hiển thị chuỗi địa chỉ đầy đủ sau khi submit -->
    @if (!empty($addressString))
        <h3>Full Address:</h3>
        <p>{{ $addressString }}</p>
    @endif

    <!-- Form để tạo địa chỉ mới -->
    <h2>Create New Address</h2>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="/index/create">
        @csrf
        <div>
            <label>Country Name:</label>
            <input type="text" name="country_name" required>
        </div>

        <div>
            <label>City Name:</label>
            <input type="text" name="city_name" required>
        </div>

        <div>
            <label>District Name:</label>
            <input type="text" name="district_name" required>
        </div>

        <div>
            <label>Ward Name:</label>
            <input type="text" name="ward_name" required>
        </div>

        <div>
            <label>Street Name:</label>
            <input type="text" name="street_name" required>
        </div>

        <div>
            <button type="submit">Create Address</button>
        </div>
    </form>

</body>

</html>
