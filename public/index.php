<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freetimers Candidate Test</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<div id="app"></div>
<script src="https://unpkg.com/mithril/mithril.js"></script>
<script>
    class View {
        units = {
            lengthUnit: 'm',
            widthUnit: 'm',
            depthUnit: 'm'
        };
        measurements = {
            length: 0,
            width: 0,
            depth: 0
        };
        bags = 0;
        validateMeasurements() {

            if (
                this.measurements.length > 0 &&
                this.measurements.width > 0 &&
                this.measurements.depth > 0
            ) {
                return true;
            }
            return false;
        }
        saveBags = () => {
            if (!this.validateMeasurements()){
                return
            }
            m.request({
                method: "POST",
                url: '/api/?action=save',
                withCredentials: true,
                body: {
                    measurements: this.measurements,
                    units: this.units
                }
            }).then((saved) => {
                if (saved)
                    alert('saved ')
            })
        }
        updateBags = () => {

            if (!this.validateMeasurements()){
                return
            }
            m.request({
                method: "POST",
                url: '/api/?action=calculate',
                withCredentials: true,
                body: {
                    measurements: this.measurements,
                    units: this.units
                }
            }).then((bags) => {
                this.bags = bags;
            })

        }
        view = () => {
            const updateUnit = (field, value) => {
                this.units[field] = value;
                this.updateBags();
            };
            const updateMeasurement = (field, value) => {
                this.measurements[field] = value;
                this.updateBags();
            };

            return [
                m("div", {class: "container mx-auto px-4 py-8"}, [
                    m("div", {class: "card bg-white shadow-md rounded-lg overflow-hidden"}, [
                        m("div", {class: "card-header p-4 border-b border-gray-200"}, [
                            m("h2", {class: "text-xl font-bold text-gray-800"}, "Freetimers Candidate Test")
                        ]),

                        m('br'),

                        m("div", {class: "card-body p-4"}, [
                            m("div", {class: "flex flex-wrap -mb-4"}, [
                                m("div", {class: "w-full flex items-center mb-4"}, [
                                    m("label", {class: "block mr-2 text-sm font-medium text-gray-700"}, "Length"),
                                    m("input", {
                                        class: "shadow appearance-none border rounded w-full px-3 py-2 text-gray-700 leading-tight focus:outline-none focus:ring-indigo-500 focus:ring-1",
                                        type: "number",
                                        placeholder: "Length",
                                        value: this.units.length,
                                        oninput: (e) => {
                                            updateMeasurement('length', parseFloat(e.target.value))
                                        }
                                    }),
                                    m("select", {
                                        class: "ml-2 form-select appearance-none block px-3 py-2 text-base font-medium text-gray-700 border rounded shadow-sm focus:outline-none focus:ring-indigo-500 focus:ring-1",
                                        value: this.measurements.lengthUnit,
                                        onchange: (e) => updateUnit('lengthUnit', e.target.value) // Removed extra closing parenthesis
                                    }, [
                                        m("option", {value: "cm"}, "Centimeters"),
                                        m("option", {value: "m"}, "Metres"),
                                        m("option", {value: "in"}, "Inches"),
                                        m("option", {value: "ft"}, "Feet"),
                                        m("option", {value: "yd"}, "Yards"),
                                    ])
                                ]),
                                m('br'),
                                m("div", {class: "w-full flex items-center mb-4"}, [
                                    m("label", {class: "block mr-2 text-sm font-medium text-gray-700"}, "Width"),
                                    m("input", {
                                        class: "shadow appearance-none border rounded w-full px-3 py-2 text-gray-700 leading-tight focus:outline-none focus:ring-indigo-500 focus:ring-1",
                                        type: "number",
                                        placeholder: "Width",
                                        value: this.units.width,
                                        oninput: (e) => {
                                            updateMeasurement('width', parseFloat(e.target.value))
                                        }
                                    }),
                                    m("select", {
                                        class: "ml-2 form-select appearance-none block px-3 py-2 text-base font-medium text-gray-700 border rounded shadow-sm focus:outline-none focus:ring-indigo-500 focus:ring-1",
                                        value: this.measurements.widthUnit,
                                        onchange: (e) => updateUnit('widthUnit', e.target.value) // Removed extra closing parenthesis
                                    }, [
                                        m("option", {value: "cm"}, "Centimeters"),
                                        m("option", {value: "m"}, "Metres"),
                                        m("option", {value: "in"}, "Inches"),
                                        m("option", {value: "ft"}, "Feet"),
                                        m("option", {value: "yd"}, "Yards"),
                                    ])
                                ]),

                                m("div", {class: "w-full flex items-center mb-4"}, [
                                    m("label", {class: "block mr-2 text-sm font-medium text-gray-700"}, "Width"),
                                    m("input", {
                                        class: "shadow appearance-none border rounded w-full px-3 py-2 text-gray-700 leading-tight focus:outline-none focus:ring-indigo-500 focus:ring-1",
                                        type: "number",
                                        placeholder: "Depth",
                                        value: this.units.depth,
                                        oninput: (e) => {
                                            updateMeasurement('depth', parseFloat(e.target.value))
                                        }
                                    }),
                                    m("select", {
                                        class: "ml-2 form-select appearance-none block px-3 py-2 text-base font-medium text-gray-700 border rounded shadow-sm focus:outline-none focus:ring-indigo-500 focus:ring-1",
                                        value: this.measurements.depthUnit,
                                        onchange: (e) => updateUnit('depthUnit', e.target.value) // Removed extra closing parenthesis
                                    }, [
                                        m("option", {value: "cm" }, "Centimeters"),
                                        m("option", {value: "m"}, "Metres"),
                                        m("option", {value: "in"}, "Inches"),
                                        m("option", {value: "ft"}, "Feet"),
                                        m("option", {value: "yd"}, "Yards"),
                                    ])
                                ]),
                            ]),
                            m('br'),
                            m("p", {class: "text-gray-700 font-bold text-3xl text-center"},
                                ` Bags : ${this.bags}`
                            ),
                            m('br'),
                            m("button", {
                                class: "px-4 py-2 rounded-md bg-blue-500 text-white flex justify-center mx-auto",
                                onclick: this.saveBags
                            }, 'Save Bags')



                        ])
                    ])
                ])
            ];
        }
    }

    m.mount(document.getElementById('app'), new View);


</script>
</body>
</html>
