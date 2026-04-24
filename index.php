<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worklog - B&W Border Edition with Dark Mode</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        /* CSS Variables for Easy Theme Swapping */
        :root {
            /* Light Mode Colors */
            --bg-color: #FFFFFF;
            --card-bg-color: #FFFFFF;
            --text-color: #000000;
            --border-color: #000000;
            --shadow-color: rgba(0,0,0,0.1);
            
            /* Form Input Colors (Light) */
            --input-bg: #FFFFFF;
            --input-border: #000000;
            --input-focus-border: #333333;
            
            /* Accent and Status Colors */
            --accent-color: #FDFCF0; /* Still keep a tiny touch of color for pastel feel */
            --success-color: #B2F2BB; 
            --danger-color: #FFB2B2;
            
            /* Toggle Button Colors (Light) */
            --toggle-bg: #F0F0F0;
            --toggle-active-bg: #E0E0E0;
            --toggle-text: #000000;
            
            /* Custom Hand-drawn Border Styles */
            --sketch-border: 2px solid var(--border-color);
            --sketch-border-thick: 3px solid var(--border-color);
        }

        /* Dark Mode Colors */
        [data-theme="dark"] {
            --bg-color: #121212;
            --card-bg-color: #1E1E1E;
            --text-color: #E0E0E0;
            --border-color: #E0E0E0;
            --shadow-color: rgba(0,0,0,0.5);
            
            --input-bg: #2C2C2C;
            --input-border: #E0E0E0;
            --input-focus-border: #FFFFFF;
            
            --accent-color: #1A1A1A;
            --success-color: #81C784; 
            --danger-color: #E57373;

            --toggle-bg: #333333;
            --toggle-active-bg: #444444;
            --toggle-text: #E0E0E0;
        }

        /* Base Styling */
        * { box-sizing: border-box; font-family: 'IBM Plex Sans Thai', sans-serif; transition: background-color 0.3s, color 0.3s, border-color 0.3s; }
        body { background-color: var(--bg-color); color: var(--text-color); margin: 0; padding: 20px; display: flex; justify-content: center; position: relative; }
        
        /* Dark Mode Switcher Button */
        .theme-switch-wrapper { position: absolute; top: 20px; right: 20px; }
        .theme-switch { cursor: pointer; background: none; border: none; padding: 8px; color: var(--text-color); display: flex; align-items: center; justify-content: center; }

        /* Container & Cards */
        .container { width: 100%; max-width: 950px; animation: fadeIn 0.8s ease; margin-top: 40px; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        h2 { text-align: center; color: var(--border-color); margin-bottom: 30px; font-weight: 600; letter-spacing: 1.5px; }
        .card { background: var(--card-bg-color); padding: 30px; border-radius: 2px; border: var(--sketch-border-thick); margin-bottom: 25px; box-shadow: 10px 10px 0px var(--shadow-color); }
        
        /* Form Styling (B&W Sketch Style) */
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; }
        .form-group { display: flex; flex-direction: column; }
        label { margin-bottom: 10px; font-weight: 600; font-size: 0.85rem; color: var(--border-color); text-transform: uppercase; }
        input, select { padding: 14px; border: var(--sketch-border); border-radius: 2px; outline: none; transition: 0.3s; font-size: 0.95rem; background: var(--input-bg); color: var(--text-color); }
        input:focus, select:focus { border-color: var(--input-focus-border); box-shadow: none; }
        
        /* Buttons (B&W Sketch Style) */
        .btn-group { display: flex; gap: 8px; border: var(--sketch-border); padding: 4px; border-radius: 2px; background: var(--input-bg); }
        .btn-toggle { flex: 1; padding: 8px; border: none; background: transparent; cursor: pointer; transition: 0.3s; color: var(--text-color); font-size: 0.85rem; font-weight: 400; }
        .btn-toggle.active { background: var(--border-color); color: var(--card-bg-color); font-weight: 600; }
        
        .btn-main { width: 100%; padding: 18px; background: var(--border-color); color: var(--card-bg-color); border: var(--sketch-border); border-radius: 2px; font-size: 1rem; font-weight: 600; cursor: pointer; margin-top: 25px; transition: 0.2s; box-shadow: 6px 6px 0px var(--shadow-color); }
        .btn-main:hover { transform: translate(-2px, -2px); box-shadow: 8px 8px 0px var(--shadow-color); opacity: 0.9; }
        .btn-main:active { transform: translate(2px, 2px); box-shadow: 4px 4px 0px var(--shadow-color); }

        /* Minimal Table & Actions */
        .table-container { overflow-x: auto; margin-top: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { padding: 18px; text-align: center; font-size: 0.75rem; color: var(--border-color); text-transform: uppercase; letter-spacing: 1.5px; border-bottom: var(--sketch-border); }
        td { padding: 18px; border-bottom: 1px solid var(--toggle-bg); font-size: 0.95rem; text-align: center; color: var(--text-color); }
        
        .action-btn { background: none; border: var(--sketch-border); cursor: pointer; padding: 6px; border-radius: 2px; transition: 0.2s; color: var(--border-color); }
        .action-btn:hover { background: var(--toggle-active-bg); color: var(--border-color); }
        .btn-del-min:hover { color: var(--danger-color); border-color: var(--danger-color); background: #FFF0F0; }
        
        /* Summary Box */
        .summary-box { background: var(--accent-color); padding: 30px; border-radius: 2px; border: var(--sketch-border); margin-top: 25px; box-shadow: 8px 8px 0px var(--shadow-color); }
        .net-income { font-size: 2rem; font-weight: 600; color: var(--text-color); margin-top: 15px; text-align: center; }
        .summary-details { display: flex; flex-wrap: wrap; justify-content: space-around; gap: 15px; font-size: 0.9rem; padding-bottom: 15px; border-bottom: 2px dashed var(--toggle-bg); }

        .filter-section { display: flex; gap: 12px; justify-content: center; margin-bottom: 30px; }
        .filter-section select { min-width: 140px; border: var(--sketch-border); box-shadow: 6px 6px 0px var(--shadow-color); }

        /* Custom SweetAlert Style */
        .swal2-popup { border-radius: 2px !important; border: var(--sketch-border-thick); font-family: 'IBM Plex Sans Thai', sans-serif !important; background-color: var(--card-bg-color) !important; color: var(--text-color) !important; padding: 2em !important; box-shadow: 10px 10px 0px var(--shadow-color) !important; }
        .swal2-title, .swal2-content { color: var(--text-color) !important; }
        .swal2-confirm { border-radius: 2px !important; background-color: var(--border-color) !important; color: var(--card-bg-color) !important; padding: 12px 30px !important; border: var(--sketch-border) !important;}
        .swal2-cancel { border-radius: 2px !important; background-color: var(--input-bg) !important; color: var(--border-color) !important; padding: 12px 30px !important; border: var(--sketch-border) !important;}
        .swal2-timer-progress-bar { background: var(--border-color) !important;}
    </style>
</head>
<body>

<div class="theme-switch-wrapper">
    <button class="theme-switch" id="themeSwitch" title="Switch Theme">
        <i data-lucide="sun" id="sunIcon"></i>
        <i data-lucide="moon" id="moonIcon" style="display:none"></i>
    </button>
</div>

<div class="container">
    <h2>✦ DAILY WORKLOG ✦</h2>

    <div class="card">
        <div class="form-grid">
            <div class="form-group"><label>วันที่</label><input type="date" id="workDate"></div>
            <div class="form-group"><label>เวลาเข้า</label><input type="time" id="timeIn"></div>
            <div class="form-group"><label>เวลาออก</label><input type="time" id="timeOut"></div>
            <div class="form-group"><label>พัก (ชม.)</label><input type="number" id="breakHr" value="1" step="0.5"></div>
            <div class="form-group">
                <label>OT (2 แรง)</label>
                <div class="btn-group">
                    <button type="button" class="btn-toggle" onclick="setToggle('ot', true, this)">Yes</button>
                    <button type="button" class="btn-toggle active" onclick="setToggle('ot', false, this)">No</button>
                </div>
            </div>
            <div class="form-group">
                <label>ปิดร้าน (40.-)</label>
                <div class="btn-group">
                    <button type="button" class="btn-toggle" onclick="setToggle('close', true, this)">Yes</button>
                    <button type="button" class="btn-toggle active" onclick="setToggle('close', false, this)">No</button>
                </div>
            </div>
        </div>
        <input type="hidden" id="editIndex" value="-1">
        <button class="btn-main" onclick="saveData()" id="btnSave">บันทึกข้อมูลวันนี้</button>
    </div>

    <div class="card">
        <div class="filter-section">
            <select id="filterMonth" onchange="renderTable()"></select>
            <select id="filterYear" onchange="renderTable()"></select>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>ชม.</th>
                        <th>OT</th>
                        <th>ปิดร้าน</th>
                        <th>รายได้</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody id="logTableBody"></tbody>
            </table>
        </div>

        <div class="summary-box" id="monthlySummary"></div>
    </div>
</div>

<script>
    let db = JSON.parse(localStorage.getItem('worklogs')) || [];
    let state = { ot: false, close: false };
    const HOURLY_RATE = 60;

    // Custom Toast Alert
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Theme Switcher Logic
    const themeSwitch = document.getElementById('themeSwitch');
    const sunIcon = document.getElementById('sunIcon');
    const moonIcon = document.getElementById('moonIcon');
    const currentTheme = localStorage.getItem('theme') || 'light';

    if (currentTheme) {
        document.documentElement.setAttribute('data-theme', currentTheme);
        if (currentTheme === 'dark') {
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'inline-block';
        }
    }

    function switchTheme() {
        let theme = document.documentElement.getAttribute('data-theme');
        if (theme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
            sunIcon.style.display = 'inline-block';
            moonIcon.style.display = 'none';
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'inline-block';
        }
    }
    themeSwitch.addEventListener('click', switchTheme);

    function init() {
        const now = new Date();
        const currentMonth = now.getMonth() + 1;
        const currentYear = now.getFullYear();

        const monthSelect = document.getElementById('filterMonth');
        const months = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        months.forEach((m, i) => {
            let opt = new Option(m, i + 1);
            if(i+1 === currentMonth) opt.selected = true;
            monthSelect.add(opt);
        });

        const yearSelect = document.getElementById('filterYear');
        for(let y = currentYear - 1; y <= currentYear + 2; y++) {
            let opt = new Option(y, y);
            if(y === currentYear) opt.selected = true;
            yearSelect.add(opt);
        }

        document.getElementById('workDate').valueAsDate = now;
        renderTable();
        lucide.createIcons();
    }

    function setToggle(type, val, btn) {
        state[type] = val;
        btn.parentElement.querySelectorAll('.btn-toggle').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    function calculateDaily(timeIn, timeOut, breakHr, isOT, isClose) {
        const start = new Date(`2000-01-01T${timeIn}`);
        const end = new Date(`2000-01-01T${timeOut}`);
        let diff = (end - start) / (1000 * 60 * 60);
        if (diff < 0) diff += 24;
        const workHours = Math.max(0, diff - breakHr);
        const incomeWork = workHours * (isOT ? HOURLY_RATE * 2 : HOURLY_RATE);
        return { workHours: workHours.toFixed(2), incomeNormal: isOT ? 0 : incomeWork, incomeOT: isOT ? incomeWork : 0, closePay: isClose ? 40 : 0, dailyTotal: incomeWork };
    }

    function saveData() {
        const dateVal = document.getElementById('workDate').value;
        const timeIn = document.getElementById('timeIn').value;
        const timeOut = document.getElementById('timeOut').value;
        const breakHr = parseFloat(document.getElementById('breakHr').value) || 0;
        const editIndex = parseInt(document.getElementById('editIndex').value);

        if(!dateVal || !timeIn || !timeOut) {
            return Swal.fire({ icon: 'warning', title: 'ลืมกรอกข้อมูลหรือเปล่า?', text: 'เช็คช่อง วันที่ และ เวลา อีกทีนะ!' });
        }

        const calc = calculateDaily(timeIn, timeOut, breakHr, state.ot, state.close);
        const dateObj = new Date(dateVal);
        const entry = { date: dateVal, month: dateObj.getMonth() + 1, year: dateObj.getFullYear(), timeIn, timeOut, breakHr, isOT: state.ot, isClose: state.close, ...calc };

        if (editIndex > -1) {
            db[editIndex] = entry;
            document.getElementById('editIndex').value = "-1";
            document.getElementById('btnSave').innerText = "บันทึกข้อมูลวันนี้";
            Toast.fire({ icon: 'success', title: 'อัปเดตเรียบร้อย!' });
        } else {
            db.push(entry);
            Toast.fire({ icon: 'success', title: 'เย้! บันทึกสำเร็จแล้ว' });
        }

        localStorage.setItem('worklogs', JSON.stringify(db));
        renderTable();
        resetForm();
    }

    function deleteEntry(index) {
        Swal.fire({
            title: 'จะลบจริงๆ หรอ?',
            text: "ลบแล้วกู้คืนไม่ได้น้า!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ลบเลย',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                db.splice(index, 1);
                localStorage.setItem('worklogs', JSON.stringify(db));
                renderTable();
                Toast.fire({ icon: 'success', title: 'ลบข้อมูลแล้วจ้า' });
            }
        })
    }

    function editEntry(index) {
        const item = db[index];
        document.getElementById('workDate').value = item.date;
        document.getElementById('timeIn').value = item.timeIn;
        document.getElementById('timeOut').value = item.timeOut;
        document.getElementById('breakHr').value = item.breakHr;
        document.getElementById('editIndex').value = index;
        document.getElementById('btnSave').innerText = "อัปเดตข้อมูลแถวที่ "  //+ (index + 1);
        
        state.ot = item.isOT;
        state.close = item.isClose;
        const groups = document.querySelectorAll('.btn-group');
        updateToggleUI(groups[0], item.isOT);
        updateToggleUI(groups[1], item.isClose);
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function updateToggleUI(group, val) {
        group.querySelectorAll('.btn-toggle').forEach(b => b.classList.toggle('active', (b.innerText === 'Yes') === val));
    }

    function resetForm() {
        document.getElementById('timeIn').value = "";
        document.getElementById('timeOut').value = "";
        state = { ot: false, close: false };
        document.querySelectorAll('.btn-toggle').forEach(b => {
            b.classList.remove('active');
            if(b.innerText === 'No') b.classList.add('active');
        });
    }

    function renderTable() {
        const fMonth = parseInt(document.getElementById('filterMonth').value);
        const fYear = parseInt(document.getElementById('filterYear').value);
        const tbody = document.getElementById('logTableBody');
        tbody.innerHTML = "";
        let totalIncome = 0, totalClosePay = 0;

        db.forEach((item, index) => {
            if(item.month === fMonth && item.year === fYear) {
                totalIncome += item.dailyTotal;
                totalClosePay += item.closePay;
                tbody.innerHTML += `<tr>
                    <td>${item.date.split('-').reverse().slice(0,2).join('/')}</td>
                    <td><span style="font-size:0.8rem">${item.timeIn}-${item.timeOut}</span></td>
                    <td>${item.workHours}</td>
                    <td>${item.isOT ? '●' : '○'}</td>
                    <td>${item.isClose ? '฿'+item.closePay : '-'}</td>
                    <td style="font-weight:600">฿${item.dailyTotal.toLocaleString()}</td>
                    <td>
                        <button class="action-btn" onclick="editEntry(${index})"><i data-lucide="edit-3" style="width:16px"></i></button>
                        <button class="action-btn btn-del-min" onclick="deleteEntry(${index})"><i data-lucide="trash-2" style="width:16px"></i></button>
                    </td>
                </tr>`;
            }
        });

        const grandTotal = totalIncome + totalClosePay;
        const tax = grandTotal * 0.05;
        const net = grandTotal - tax;

        document.getElementById('monthlySummary').innerHTML = `
            <div class="summary-details">
                <div>งาน <b>฿${totalIncome.toLocaleString()}</b></div>
                <div>ปิดร้าน <b>฿${totalClosePay.toLocaleString()}</b></div>
                <div>ภาษี 5% <b>-฿${tax.toLocaleString()}</b></div>
            </div>
            <div class="net-income">รวมสุทธิ ฿${net.toLocaleString()}</div>
        `;
        lucide.createIcons();
    }

    init();
</script>
</body>
</html>
