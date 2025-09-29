import React from "react";

export default function Step3VehicleSelection({
                                                  vehicles,
                                                  selectedVehicle,
                                                  setSelectedVehicle,
                                                  onNext,
                                                  onBack,
                                                  pickupDatetime,
                                                  returnDatetime,
                                              }) {
    return (
        <div>
            <h2 className="mb-4 font-semibold text-lg">Choose a car</h2>
            {(!pickupDatetime || !returnDatetime) && (
                <p className="text-red-600 mb-4">Please, firstly pick dates of pickup and return.</p>
            )}

            <div className="overflow-x-auto">
                <table className="min-w-full border border-gray-300 rounded-md overflow-hidden">
                    <thead className="bg-gray-100 text-gray-700 text-sm">
                    <tr>
                        <th className="p-3">Image</th>
                        <th className="p-3">Name</th>
                        <th className="p-3">Price</th>
                        <th className="p-3"></th>
                    </tr>
                    </thead>
                    <tbody className="text-gray-800">
                    {vehicles.length === 0 && (
                        <tr>
                            <td colSpan={4} className="p-4 text-center">
                                No available cars for these dates
                            </td>
                        </tr>
                    )}
                    {vehicles.map((v) => (
                        <tr key={v.id} className={`border-t ${selectedVehicle?.id === v.id ? "bg-blue-100" : ""}`}>
                            <td className="p-3">
                                <img src={v.image} alt={v.name} className="w-24 rounded" />
                            </td>
                            <td className="p-3 text-center">{v.name}</td>
                            <td className="p-3 text-center">{v.price}</td>
                            <td className="p-3 text-right">
                                <button
                                    onClick={() => setSelectedVehicle(v)}
                                    className={`px-4 py-1 rounded ${
                                        selectedVehicle?.id === v.id
                                            ? "bg-green-600 text-white"
                                            : "bg-blue-600 text-white hover:bg-blue-700"
                                    }`}
                                >
                                    {selectedVehicle?.id === v.id ? "Chosen" : "Choose"}
                                </button>
                            </td>
                        </tr>
                    ))}
                    </tbody>
                </table>
            </div>

            <div className="mt-6 flex justify-between">
                <button
                    onClick={onBack}
                    className="px-6 py-2 rounded border border-gray-400 hover:bg-gray-100"
                >
                    Back
                </button>
                <button
                    disabled={!selectedVehicle}
                    onClick={onNext}
                    className={`px-6 py-2 rounded text-white ${
                        selectedVehicle ? "bg-blue-600 hover:bg-blue-700" : "bg-gray-400 cursor-not-allowed"
                    }`}
                >
                    Next
                </button>
            </div>
        </div>
    );
}
