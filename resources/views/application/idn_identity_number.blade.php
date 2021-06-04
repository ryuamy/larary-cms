<form class="row form-input" method="POST" action="{{ url('test_idn_identity_number') }}">
    <input type="text" value="3175065710910003" name="idn_identity_number" />
    <button type="submit">Test</button>

    @csrf
</form>
