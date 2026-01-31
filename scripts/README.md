# MCOP Quest Asset Generation Scripts

Scripts สำหรับสร้าง pixel art assets สำหรับ MCOP Quest World Map โดยใช้ Replicate API (flux-pixel-art model)

## 🚀 Quick Start

### 1. สมัคร Replicate Account
- ไปที่: https://replicate.com
- สมัคร account (มีเครดิตฟรี $5 เริ่มต้น)
- ไปที่ https://replicate.com/account/api-tokens
- Copy API token

### 2. ตั้งค่า Environment Variable

```bash
export REPLICATE_API_TOKEN='your_token_here'
```

หรือเพิ่มใน `~/.zshrc` หรือ `~/.bashrc`:
```bash
echo 'export REPLICATE_API_TOKEN="your_token_here"' >> ~/.zshrc
source ~/.zshrc
```

### 3. Install Dependencies

```bash
# ตรวจสอบว่ามี Python 3.8+ และ pip
python3 --version

# Install requests (ถ้ายังไม่มี)
pip install requests
```

### 4. สร้าง Assets

```bash
# สร้างทั้งหมด 6 assets
./generate-mcop-assets.py

# สร้างเฉพาะ asset ใด asset หนึ่ง
./generate-mcop-assets.py --asset castle.png

# สร้างทั้งหมด พร้อม delay 5 วินาทีระหว่างรูป (ป้องกัน rate limit)
./generate-mcop-assets.py --delay 5
```

## 📁 Output Location

Assets จะถูกบันทึกที่:
```
_bmad-output/prototypes/mcop-quest/v2/assets-v2/
```

ประกอบด้วย:
- `castle.png` - Main castle (Member City)
- `task_tower.png` - Task Tower
- `bug_bastion.png` - Bug Bastion (forest dungeon)
- `alchemy_lab.png` - Analytics Alchemy Lab
- `community_commons.png` - Community Commons (market)
- `payment_fortress.png` - Payment Fortress (dark castle)

## 🔧 Scripts ที่มี

### 1. `generate-mcop-assets.py` (แนะนำ)
Python script ใช้งานง่าย รองรับ:
- Batch generation
- Progress tracking
- Error handling
- Custom output directory

### 2. `replicate-image-gen.sh`
Bash script สำหรับใช้งานผ่าน command line ทั่วไป

## 💰 ค่าใช้จ่าย Replicate

flux-pixel-art model:
- ราคา: ~$0.003-0.005 ต่อรูป (512x512)
- $5 เครดิตฟรี = ~1,000+ รูป

ตรวจสอบยอด: https://replicate.com/account/billing

## 🎨 เกี่ยวกับ flux-pixel-art Model

- **Creator**: @alvdansen
- **Style**: Consistent pixel art generation
- **Best for**: RPG game assets, retro game sprites
- **Prompt tips**: เพิ่ม "pixel art" และ "RPG style" เข้าไปใน prompt จะได้ผลลัพธ์ดีขึ้น

## 🆚 เทียบกับ Pollinations

| Feature | Replicate (flux-pixel-art) | Pollinations |
|---------|---------------------------|--------------|
| สไตล์ consistency | ⭐⭐⭐⭐⭐ ดีมาก | ⭐⭐⭐ ปานกลาง |
| Pixel art quality | ⭐⭐⭐⭐⭐ เหมาะสม | ⭐⭐⭐ ต้อง retry บ่อย |
| ความเร็ว | ⭐⭐⭐⭐ เร็ว | ⭐⭐⭐⭐⭐ เร็วมาก |
| ราคา | ⭐⭐⭐ มีค่าใช้จ่าย | ⭐⭐⭐⭐⭐ ฟรี |
| Transparency | ⭐⭐⭐ ขึ้นกับ prompt | ⭐⭐⭐ ขึ้นกับ prompt |

## 🐛 Troubleshooting

### Error: REPLICATE_API_TOKEN not set
```bash
export REPLICATE_API_TOKEN='r8_xxxxxxxxxxxxxxxx'
```

### Error: No module named 'requests'
```bash
pip install requests
```

### Error: Prediction failed
- ตรวจสอบ internet connection
- ลองรันใหม่ (Replicate มี retry logic อัตโนมัติ)
- ตรวจสอบว่า API token ยัง valid อยู่

### Rate limiting
ถ้าสร้างหลายรูปติดๆ กัน ให้เพิ่ม delay:
```bash
./generate-mcop-assets.py --delay 3
```

## 📝 Customization

แก้ไข prompts ใน `generate-mcop-assets.py` ที่ dictionary `ASSETS`:

```python
ASSETS = {
    "castle.png": {
        "prompt": "your custom prompt here",
        "width": 512,
        "height": 512
    }
}
```

## 🔗 Useful Links

- Replicate: https://replicate.com
- flux-pixel-art model: https://replicate.com/alvdansen/flux-pixel-art
- API Docs: https://replicate.com/docs
