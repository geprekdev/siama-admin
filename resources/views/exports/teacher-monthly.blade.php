<table>
  <thead>
    <tr>
      <th colspan="4" style="font-weight: 700">Rekap Kehadiran Siswa Guru/Karyawan -
        {{ $date }}</th>
    </tr>
    <tr>
      <th>#</th>
      <th>Nama</th>
      <th>Hadir</th>
      <th>Terlambat</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($attendances as $name => $statuses)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $name }}</td>
        <td>{{ array_key_exists('H', $statuses->toArray()) ? $statuses['H']->count() : 0 }}</td>
        <td>{{ array_key_exists('T', $statuses->toArray()) ? $statuses['T']->count() : 0 }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
