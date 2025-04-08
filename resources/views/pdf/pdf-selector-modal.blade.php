<div class="space-y-4">
    @if($servicios->isEmpty())
        <p class="text-gray-400">Este equipo aún no tiene servicios registrados.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse text-sm text-left text-gray-300">
                <thead
                    class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3">Fecha</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3">Técnico</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3 text-center">Acción</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                @foreach($servicios as $servicio)
                    <tr class="hover:bg-gray-800 transition">
                        <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($servicio->fecha_reparacion)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $servicio->tipo_servicio == 0 ? 'Mantenimiento preventivo' : 'Mantenimiento correctivo' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $servicio->tecnico_responsable }}</td>
                        <td class="px-4 py-3">
                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                                    {{ $servicio->estado_final == 0 ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400' }}">
                                    {{ $servicio->estado_final == 0 ? 'Funcional' : 'Devuelto sin funcionar' }}
                                </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('servicio.pdf', $servicio->id) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1 px-3 py-1 text-sm font-medium rounded bg-orange-600 hover:bg-orange-500 text-white transition">
                                <x-heroicon-o-printer class="w-4 h-4"/>
                                PDF
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
